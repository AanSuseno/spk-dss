<?php

namespace App\Models;

use CodeIgniter\Model;

class Users extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = false;
    protected $allowedFields    = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function login($email, $name, $picture)
    {
        $imageData = file_get_contents($picture);
        $imageBlob = $imageData;
        $user = $this->where('email', $email)->get()->getRowArray();
        if ($user == null) {
            $this->insert([
                'email' => $email,
                'name' => $name,
                'picture' => $imageBlob,
                'status' => 'aktif'
            ]);
            $user['id'] = $this->insertId();
        } else {
            if ($user['status'] != 'aktif') return $user['status'];

            $this->update($user['id'], [
                'name' => $name,
                'picture' => $imageBlob,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }

        session()->set('id', $user['id']);
        return "oke";
    }
}
