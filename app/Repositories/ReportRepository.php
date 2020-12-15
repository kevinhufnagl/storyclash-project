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
         * Using Eloquent in Laravel
         */
        $report = $this->report->create([
            'title' => $data['title'],
            'icon' => $data['icon']
        ]);

        /**
         * Direct SQL Insert statement
         */
        /*$report = DB::insert('insert into reports (title, icon, created_at, updated_at) values (?, ?, ?, ?)',
            [$data['title'], $data['icon'], Carbon::now(), Carbon::now()]
        );*/
        
        return $report;
    }

    public function update($data, $id) {
       //DB::update('update reports set title = ? where id = ?', [$data['title'], $id]);
       $report = $this->report->find($id);
       $report->title = $data['title'];
       $report->update();

       return $report;
    }

    public function delete($id) {
        //DB::delete('delete from reports where id = ?', [$id]);

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
        //return DB::select('select * from reports');
        return $this->report->get();
    }

}