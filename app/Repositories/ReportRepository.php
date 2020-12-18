<?php

namespace App\Repositories;

use App\Models\Report;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportRepository {

    protected $report;

        
    /**
     * __construct
     *
     * @param  mixed $report
     * @return void
     */
    public function __construct(Report $report) {
        $this->report = $report;
    }
    
    /**
     * save
     *
     * @param  mixed $data
     * @return void
     */
    public function save($data) {
        /**
         * DML
         * DB::insert('insert into reports (title, icon, created_at, updated_at) values (?, ?, ?, ?)',[$data['title'], $data['icon'], Carbon::now(), Carbon::now()]);
         */

        /**
         * Using Eloquent in Laravel
         */
        $report = $this->report->create([
            'title' => $data['title'],
            'icon' => $data['icon']
        ]);
        
        return $report;
    }

    public function update($data, $id) {
       //
       /**
        * DML
        * DB::update('update reports set title = ?, updated_at = ? where id = ?', [$data['title'], Carbon::now(), $id]);
        */

        /**
         * Using Eloquent in Laravel
         */
       $report = $this->report->find($id);
       $report->title = $data['title'];
       $report->update();

       return $report;
    }

    public function delete($id) {

        /**
         * DML
         * DB::delete('delete from reports where id = ?', [$id]);
         */

         /**
         * Using Eloquent in Laravel
         */


        /**
         * Soft delete alternatively
         */
        /*
        $report = $this->report->find($id);
        $report->deleted_at = Carbon::now();
        $report->update();
        */

        $report = $this->report->find($id);
        $report->delete();

        return $report;
    }
    
    /**
     * getAll
     *
     * @return Array
     */
    public function getAll() {
        /**
         * DML
         * DB::select('select * from reports');
         */

         /**
         * Using Eloquent in Laravel
         */

        /**
         * Soft delete alternatively
         */
        //return $this->report->whereNull('deleted_at')->get();
        return $this->report->get();
    }

}