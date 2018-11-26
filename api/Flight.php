<?php
/**
 * Class Flight
 * Отримання даних по рейсах при вхідних даних (
        [
            'departureAirport' => 'XXX',
            'arrivalAirport' => 'XXX',
            'departureDate => 'XXXX-XX-XX'
 *      ]
 * )
 *
 * Прийнято рішення денормалізувати БД і зберігати аеропорти у вигляді назв в табличці з рейсами
 * щоб не додавати ще два джойни у вибірку рейсів
 * (для малої к-сті записів це не принципово, але можна припустити, що система в майбутньому матиме більше записів)
 * крім того рейси мають зомнішні ключі на аеропорти для цілісності даних
 */

class Flight
{
    private $db;
    private $request;
    private $errors = [];

    public function __construct($request)
    {
        $this->db = DB::getInstance();
        $this->request = $request;
    }

    /**
     * Set 404 header status
     * in case of error
     */
    public function setErrorStatus()
    {
        header("HTTP/1.0 404 Not Found");
    }

    /**
     * Get flights data from DB
     *
     * @return array
     */
    public function getData()
    {
        $sql =  sprintf("SELECT `raices`.*, t.name AS tName, t.code as tCode
                FROM `raices`
                LEFT JOIN transporter t 
                  ON raices.transporter = t.id
                WHERE arrivalAirport='%s'
                  AND departureAirport='%s'
                  AND DATE(departureTime)='%s'
                ORDER BY departureTime ASC
                ",
            $this->request['arrivalAirport'],
            $this->request['departureAirport'],
            $this->request['departureDate']
        );

        $flights = $this->db->db_query_select($sql);

        $res = [];

        foreach($flights as $flight) {

            $res[] = [
                "transporter" => [
                    'code' => $flight['tCode'],
                    'name' => $flight['tName'],
                ],
                "flightNumber" => $flight['flightNumber'],
                "departureAirport" => $flight['departureAirport'],
                "arrivalAirport" => $flight['arrivalAirport'],
                "departureDateTime" => date("Y-m-d H:i", strtotime($flight['departureTime'])),
                "arrivalDateTime" => date("Y-m-d H:i", strtotime($flight['arrivalTime'])),
                "duration" => $flight['duration'],
            ];
        }

        return $res;
    }

    /**
     * Validate incoming data
     *
     * @return bool
     */
    private function validate()
    {
        $this->validateTheSameAirports('arrivalAirport', $this->request['departureAirport'], $this->request['arrivalAirport']);
        $this->validateAirport('departureAirport', $this->request['departureAirport']);
        $this->validateAirport('arrivalAirport', $this->request['arrivalAirport']);
        $this->validateDate('departureDate', $this->request['departureDate']);

        if (empty($this->errors)) {
            return true;
        }
    }

    /**
     * Check are arrival and departure airports different
     *
     * @param $prop
     * @param $a1
     * @param $a2
     * @return bool
     */
    private function validateTheSameAirports($prop, $a1, $a2)
    {
        if ($a1 == $a2) {
            $this->errors[$prop] = 'Arrival and departure airports are the same';
            return false;
        }

        return true;
    }

    /**
     * Check is date not in the past
     *
     * @param $prop
     * @param $value
     * @return bool
     */
    private function validateDate($prop, $value)
    {
        if (empty($value)) {
            $this->errors[$prop] = 'Empty date';
            return false;
        }

        if (strtotime(date('Y-m-d', time())) > strtotime($value)) {
            $this->errors[$prop] = 'Select date bigger today';
            return false;
        }

        return true;
    }

    /**
     * Validate airport data
     *
     * @param $prop
     * @param $value
     * @return bool
     */
    private function validateAirport($prop, $value)
    {
        if (empty($value)) {
            $this->errors[$prop] = 'Empty airport name';
            return false;
        }
        $res = $this->db->db_query_count(
            sprintf("SELECT * FROM airport WHERE name='%s'", $value) // TODO implement injections protection
        );

        if ($res == 0) {
            $this->errors[$prop] = 'Such airport "'.$value.'" doesn\'t exist';
            return false;
        }

        return true;
    }

    /**
     * Api method
     * Show search airports results
     */
    public function search()
    {
        if (!$this->validate()) {
            $response = ['errors' => $this->errors];
        } else {
            $data = $this->getData();
            if (empty($data)) {
                $response = "No results found";
            }
            else {
                $response = [
                    'searchQuery' => $this->request,
                    'searchResults' => $data
                ];
            }
        }

        echo (json_encode($response));
    }
}