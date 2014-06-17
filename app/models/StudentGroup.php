<?php

/**
 * Student group model
 *
 * @property string $id
 * @property-read Course $course
 * @property-read User $tutor
 * @property \Illuminate\Database\Eloquent\Collection|Students[] $students
 * @property string $course_id
 * @property string $tutor_user_id
 */
class StudentGroup extends BaseModel {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'student_group';

    public function course()
    {
        return $this->belongsTo('Course');
    }

    public function students()
    {
        return $this->belongsToMany('User',
            'student_group_student', null, 'student_user_id');
    }

    public function tutor()
    {
        return $this->belongsTo('User', 'tutor_user_id');
    }
}