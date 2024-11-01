<?php


namespace App\Traits;


use App\Models\User;

trait CreatedByUpdatedByRelationship
{
    /**
     * createdBy
     *
     * @return void
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
