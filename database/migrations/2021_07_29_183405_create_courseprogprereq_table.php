<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseprogprereqTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('CourseProgrammePrereq', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->foreignID('course_programme_id')
                ->contstrained('CourseProgramme')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreignID('prereq_course_programme_id')
                ->contstrained('CourseProgramme')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });

        
    

        DB::table('CourseProgrammePreReq')->insert(
            array(
                   'course_programme_id'   =>   '6',
                   'prereq_course_programme_id'   =>   '2',
            )
        );

        DB::table('CourseProgrammePreReq')->insert(
            array(
                   'course_programme_id'   =>   '14',
                   'prereq_course_programme_id'   =>   '10',
            )
        );

        DB::table('CourseProgrammePreReq')->insert(
            array(
                   'course_programme_id'   =>   '19',
                   'prereq_course_programme_id'   =>   '16',
            )
        );

        DB::table('CourseProgrammePreReq')->insert(
            array(
                   'course_programme_id'   =>   '23',
                   'prereq_course_programme_id'   =>   '20',
            )
        );

        DB::table('CourseProgrammePreReq')->insert(
            array(
                   'course_programme_id'   =>   '25',
                   'prereq_course_programme_id'   =>   '22',
            )
        );

        DB::table('CourseProgrammePreReq')->insert(
            array(
                   'course_programme_id'   =>   '27',
                   'prereq_course_programme_id'   =>   '23',
            )
        );

        DB::table('CourseProgrammePreReq')->insert(
            array(
                   'course_programme_id'   =>   '31',
                   'prereq_course_programme_id'   =>   '23',
            )
        );

        DB::table('CourseProgrammePreReq')->insert(
            array(
                   'course_programme_id'   =>   '31',
                   'prereq_course_programme_id'   =>   '29',
            )
        );


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('CourseProgrammePrereq');
    }
}
