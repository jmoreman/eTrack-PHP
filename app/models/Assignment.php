<?php

/**
 * Assignment model
 *
 * @property string $id
 * @property-read Unit $unit
 * @property string $brief
 * @property string $status
 * @property DateTime $available_date
 * @property DateTime $deadline
 * @property DateTime $marking_start_date
 * @property DateTime $marking_deadline
 * @property-read \Illuminate\Database\Eloquent\Collection|Criteria[] $criteria
 */
class Assignment extends BaseModel {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'assignment';

    public function unit()
    {
        return $this->belongsTo('Unit');
    }

    public function criteria()
    {
        return Criteria::where('assignment_id', $this->id)
            ->select('criteria.id', 'criteria.type')
            ->join('assignment_criteria', function($join)
            {
                $join->on('criteria.id', '=', 'assignment_criteria.criteria_id')
                     ->on('criteria.unit_id', '=', 'assignment_criteria.criteria_unit_id');
            })
            ->orderBy('type', 'desc');
    }

    public function submissions()
    {
        return $this->hasMany('AssignmentSubmission');
    }

}