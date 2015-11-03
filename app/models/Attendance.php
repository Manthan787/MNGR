<?php

class Attendance extends Eloquent {

  protected $table = "attendances";
  protected $fillable = ['date', 'batch_id'];

  public function batch() {
      return $this->belongsTo('Batch');
  }

  public function students() {
      return $this->belongsToMany('Student');
  }
}

?>
