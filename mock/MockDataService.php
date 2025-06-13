<?php

class MockDataService {
    private $data;
    private $dataFile;

    public function __construct() {
        $this->dataFile = __DIR__ . '/data.json';
        $this->loadData();
    }

    private function loadData() {
        if (file_exists($this->dataFile)) {
            $jsonContent = file_get_contents($this->dataFile);
            $this->data = json_decode($jsonContent, true);
        } else {
            throw new Exception('Mock data file not found');
        }
    }

    public function getCurrentUser() {
        return $this->data['user'];
    }

    public function getAppointments() {
        return $this->data['appointments'];
    }

    public function getRecentActivity() {
        return $this->data['recent_activity'];
    }

    public function getMedications() {
        return $this->data['medications'];
    }

    public function getConditions() {
        return $this->data['conditions'];
    }

    public function getRecentBills() {
        return $this->data['recent_bills'];
    }

    public function getNotifications() {
        return $this->data['notifications'];
    }

    public function getMessages() {
        return $this->data['messages'];
    }

    public function addAppointment($appointment) {
        $appointment['id'] = uniqid();
        $this->data['appointments'][] = $appointment;
        return $appointment;
    }

    public function updateAppointment($id, $appointment) {
        foreach ($this->data['appointments'] as $key => $apt) {
            if ($apt['id'] === $id) {
                $this->data['appointments'][$key] = array_merge($apt, $appointment);
                return $this->data['appointments'][$key];
            }
        }
        return null;
    }

    public function deleteAppointment($id) {
        foreach ($this->data['appointments'] as $key => $apt) {
            if ($apt['id'] === $id) {
                unset($this->data['appointments'][$key]);
                $this->data['appointments'] = array_values($this->data['appointments']);
                return true;
            }
        }
        return false;
    }

    public function addMedication($medication) {
        $medication['id'] = uniqid();
        $this->data['medications'][] = $medication;
        return $medication;
    }

    public function updateMedication($id, $medication) {
        foreach ($this->data['medications'] as $key => $med) {
            if ($med['id'] === $id) {
                $this->data['medications'][$key] = array_merge($med, $medication);
                return $this->data['medications'][$key];
            }
        }
        return null;
    }

    public function addCondition($condition) {
        $condition['id'] = uniqid();
        $this->data['conditions'][] = $condition;
        return $condition;
    }

    public function updateCondition($id, $condition) {
        foreach ($this->data['conditions'] as $key => $cond) {
            if ($cond['id'] === $id) {
                $this->data['conditions'][$key] = array_merge($cond, $condition);
                return $this->data['conditions'][$key];
            }
        }
        return null;
    }

    public function addBill($bill) {
        $bill['id'] = uniqid();
        $this->data['recent_bills'][] = $bill;
        return $bill;
    }

    public function updateBill($id, $bill) {
        foreach ($this->data['recent_bills'] as $key => $b) {
            if ($b['id'] === $id) {
                $this->data['recent_bills'][$key] = array_merge($b, $bill);
                return $this->data['recent_bills'][$key];
            }
        }
        return null;
    }

    public function addNotification($notification) {
        $notification['id'] = uniqid();
        $this->data['notifications'][] = $notification;
        return $notification;
    }
}