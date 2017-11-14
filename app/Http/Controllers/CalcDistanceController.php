<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

/**
 * Class CalcDistanceController
 * @package App\Http\Controllers
 */
class CalcDistanceController extends BaseController
{
    protected $distance;
    protected $duration;
    protected $cost;
    protected $distancePerLiter;
    protected $pricePerLiter;

    /**
     * @param Request $request
     * @return mixed
     */
    public function calculate(Request $request)
    {
        $data = $request->json()->all();
        $originLat = $data['origin'][0]['latitude'];
        $originLong = $data['origin'][0]['longitude'];
        $destinationLat = $data['destination'][0]['latitude'];
        $destinationLong = $data['destination'][0]['longitude'];
        $vehicleType = $data['vehicle'][0]['type'];
        $this->distancePerLiter = $data['vehicle'][0]['distance_per_litre'];
        $this->pricePerLiter = $data['vehicle'][0]['price_per_litre'];

        $this->distance = distanceToKilometer($originLat, $originLong, $destinationLat, $destinationLong);

        $this->duration = $this->calcDuration();

        $this->cost = $this->calcCost();

        $response['distance'] = array('x', $this->distance);
        $response['duration'] = array('y', HoursToMinutes($this->duration));
        $response['cost'] = array('z', $this->cost);

        return $response;
    }

    /**
     * @return float|int
     */
    public function calcDuration()
    {
        return $this->distance / $this->avgSpeed();
    }

    /**
     * @return int
     */
    public function avgSpeed()
    {
        return 65;
    }

    /**
     * @return float|int
     */
    public function getConsumptionLiter()
    {
        return $this->distance / $this->distancePerLiter;
    }

    /**
     * @return float|int
     */
    public function calcCost()
    {
        return $this->getConsumptionLiter() * $this->pricePerLiter;
    }

}
