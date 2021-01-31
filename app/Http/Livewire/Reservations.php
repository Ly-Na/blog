<?php

namespace App\Http\Livewire;

use App\Models\Reservation;
use App\Models\Salle;
use DateTime;
use Livewire\Component;

class Reservations extends Component
{public $listDays;
    public $Reservations, $Reservation_id, $user_id, $salle_id, $date, $debut, $fin, $nom_unite, $description, $Salles;

    public $isOpen = 0;

    public $selectedSalle = 0;
    public $salleSelected = 0;
    public $dateSelected = 0;
    public $dateSetSelected = 0;
    public $selectedMonth = 0;

    public $datet;
    public $month;
    public $months = array(
        'January',
        'February',
        'March',
        'April',
        'May',
        'June',
        'July ',
        'August',
        'September',
        'October',
        'November',
        'December',
    );

    protected $listeners = [
        'refresh' => 'reload',
        'selected' => 'select',
        'selectDate' => 'dateselect',
        'selectReservation' => 'reservationselect'];
    public function reload()
    {
        $this->salleSelected = 0;
        $this->selectedSalle = 0;
        $this->dateSelected = 0;
        $this->dateSetSelected = 0;
        $this->selectedMonth = 0;

    }
    public function monthselected()
    {

    }
    public function select($post)
    {
        $this->salleSelected = $post;

    }
    public function dateselect($post)
    {
        $this->dateSelected = $post;

    }
   
    public function reservationselect($post)
    {
        $this->dateSetSelected = ltrim($post, '0');

    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function render()
    {
        $this->user_id = \Auth::user()->id;
        $dt = $this->selectedMonth != 0 ? DateTime::createFromFormat('!m', $this->selectedMonth) : DateTime::createFromFormat('!m', (new DateTime())->format('m'));

        $this->month = $dt->format('F');
        $start_date = $this->selectedMonth != 0 ? "01-" . $this->selectedMonth . (new DateTime())->format('-y') : "01-" . (new DateTime())->format('-m-y');

        $start_time = strtotime($start_date);

        $end_time = strtotime("+1 month", $start_time);
        $listDays = [];
        for ($i = $start_time; $i < $end_time; $i += 86400) {
            $listDays[] = date('Y-m-d-D', $i);
        }

        $this->listDays = $listDays;

        if ($this->salleSelected != 0 && $this->dateSelected != 0) {
            $this->Reservations = Reservation::where("salle_id", $this->salleSelected)->where('date', '=', $this->selectedMonth != 0 ? (new DateTime())->format('Y-') . $this->selectedMonth . '-' . $this->dateSelected : (new DateTime())->format('Y-m-') . $this->dateSelected)->get();
        } else if ($this->salleSelected != 0 || $this->dateSelected != 0) {
            if ($this->salleSelected != 0) {
                $this->Reservations = $this->selectedMonth == 0 ? Reservation::where("salle_id", $this->salleSelected)->get() : Reservation::where("salle_id", $this->salleSelected)->whereMonth('date', $this->selectedMonth)->get();
            }if ($this->dateSelected != 0) {
                $this->Reservations = Reservation::where('date', '=', $this->selectedMonth != 0 ? (new DateTime())->format('Y-') . $this->selectedMonth . '-' . $this->dateSelected : (new DateTime())->format('Y-m-') . $this->dateSelected)->get();
            }
        }if (($this->salleSelected == 0 && $this->dateSelected == 0) && $this->selectedMonth != 0) {
            $this->Reservations = Reservation::whereMonth('date', $this->selectedMonth)->get();} else if ($this->salleSelected == 0 && $this->dateSelected == 0 && $this->selectedMonth == 0) {
            $this->Reservations = Reservation::all();
        }
        $this->Salles = Salle::all();
        return view('livewire.Reservations.Reservations');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function openModal()
    {
        $this->isOpen = true;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function closeModal()
    {
        $this->isOpen = false;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    private function resetInputFields()
    {
        $this->title = '';
        $this->body = '';
        $this->Reservation_id = '';
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function store()
    {
        $this->validate([
            'salle_id' => 'required',
            'date' => 'required|date|after:yesterday',
            'fin' => 'required',

            'debut' => ['required', function ($attribute, $value, $fail) {

                $dispo = $this->getDisponibilite();
                if (!$dispo['isDispo']) {
                    $fail($dispo['message']);
                }
            },
            ], 'fin' => ['required', function ($attribute, $value, $fail) {

                $dispo = $this->getDisponibilite();
                if (!$dispo['isDispo']) {
                    $fail($dispo['message']);
                }
            },
            ],
        ]);

        Reservation::updateOrCreate(['id' => $this->Reservation_id], [
            'user_id' => $this->user_id,
            'salle_id' => $this->salle_id,
            'date' => $this->date,
            'debut' => $this->debut,
            'fin' => $this->fin,
            'nom_unite' => $this->nom_unite,
            'description' => $this->description,

        ]);

        session()->flash('message',
            $this->Reservation_id ? 'Reservation Updated Successfully.' : 'Reservation Created Successfully.');

        $this->closeModal();
        $this->resetInputFields();
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function edit($id)
    {
        $Reservation = Reservation::findOrFail($id);
        $this->Reservation_id = $id;
        $this->user_id = $Reservation->user_id;
        $this->salle_id = $Reservation->salle_id;
        $this->date = $Reservation->date;
        $this->debut = $Reservation->debut;
        $this->fin = $Reservation->fin;
        $this->nom_unite = $Reservation->nom_unite;
        $this->description = $Reservation->description;

        $this->openModal();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function delete($id)
    {
        Reservation::find($id)->delete();
        session()->flash('message', 'Reservation Deleted Successfully.');
    }
    public function change()
    {

    }

    public function getDisponibilite()
    {
        $dispo = true;

        $Reservations = Reservation::where("salle_id", $this->salle_id)->where('date', '=', $this->date)->get();
        $date1 = DateTime::createFromFormat('H:i', $this->debut);
        $date2 = DateTime::createFromFormat('H:i', $this->fin);
        if ($date2 <= $date1) {
            return array("isDispo" => !$dispo, "message" => "L'heure de debut doit etre avant l'heure de fin");
        } else {
            foreach ($Reservations as $res) {

                $date3 = DateTime::createFromFormat('H:i', $res->debut);
                $date4 = DateTime::createFromFormat('H:i', $res->fin);

                if (($date1 >= $date3 && $date1 <= $date4) && ($date2 >= $date3 && $date2 <= $date4)) {

                    return array("isDispo" => !$dispo, "message" => 'La salle est deja occuper a cet heure!De ' . $res->debut . 'h a ' . $res->fin . 'h');

                } else if ($date1 >= $date3 && $date1 <= $date4) {

                    return array("isDispo" => !$dispo, "message" => 'La date de debut se trouve dans une plage deja occupe!De ' . $res->debut . 'h a ' . $res->fin . 'h');

                } else if ($date2 >= $date3 && $date2 <= $date4) {
                    return array("isDispo" => !$dispo, "message" => 'La date de fin se trouve dans une plage deja occupe!De ' . $res->debut . 'h a ' . $res->fin . 'h');
                }

            }

        }

        return array("isDispo" => $dispo, "message" => null);

    }

}
