<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    // short description of what belongsTo and hasMany refers to :

        #Let's take an example, I have two tables called Guardian and Child. Guardian has no access to Child but Child has. So for Child Model I have to belongsTo and for Guardian I have to use hasMany (cause Guardian has many childs).

        #Let me show the table structure little bit more, 
        #Guardian Table has column called id and name. And child table has column called id, guardianId, and Name.
    
            #Yes, that's correct. Based on the table structure you described, you would define a belongsTo relationship on the Child model and a hasMany relationship on the Guardian model.

            #Here's an example code that you can use to define the relationships:
            // class Child extends Model
            // {
            //     public function guardian()
            //     {
            //         return $this->belongsTo(Guardian::class);
            //     }
            // }

            // class Guardian extends Model
            // {
            //     public function children()
            //     {
            //         return $this->hasMany(Child::class);
            //     }
            // }

    public function invoice(){
        return $this-> belongsTo(Customer::class);
    }
}
