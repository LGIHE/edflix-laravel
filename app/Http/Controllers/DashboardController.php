<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Logs;
use App\Models\User;
use App\Models\Subject;
use App\Models\School;
use App\Models\LessonPlan;
use App\Models\LessonStep;

class DashboardController extends Controller
{
    public function index()
    {
        if (auth()->user()->isAdmin()) {
            $teachers = User::all()->where('role', 'Teacher');
            $facilitators = User::all()->where('role', 'Facilitator');
            $schools = School::all();
            $lessonPlans = lessonPlan::all();
            $steps = lessonStep::all();

            // Get the first and last day of the week
            $firstDayOfWeek = date('Y-m-d', strtotime('this week'));
            $lastDayOfWeek = date('Y-m-d', strtotime('this week +6 days'));

            //Last week days
            $currentDate = Carbon::now();
            $firstDayOfLastWeek = $currentDate->subWeek()->startOfWeek();
            $lastDayOfLastWeek = $currentDate->endOfWeek();

            //Usage Stats
            $logs = Logs::all()->filter(function ($item) use ($firstDayOfWeek, $lastDayOfWeek) {
                return ($item['created_at'] >= $firstDayOfWeek && $item['created_at'] <= $lastDayOfWeek) ||
                       ($item['updated_at'] >= $firstDayOfWeek && $item['updated_at'] <= $lastDayOfWeek);
            });

            $logsArray = $logs->toArray();
            $groupedStats = collect($logsArray)->groupBy(function ($log) {
                return date('Y-m-d', strtotime($log['created_at']));
            });
            $groupedLogsArray = $groupedStats->toArray();

            $logsPerDay = [];

            $currentDay = $firstDayOfWeek;
            while ($currentDay <= $lastDayOfWeek) {
                // Check if the current day exists in the grouped array
                if (isset($groupedLogsArray[$currentDay])) {
                    // Get the count of users for the current day and store it in the array
                    $logsPerDay[] = count($groupedLogsArray[$currentDay]);
                } else {
                    // If the current day does not exist in the grouped array, store 0 in the array
                    $logsPerDay[] = 0;
                }

                // Move to the next day
                $currentDay = date('Y-m-d', strtotime($currentDay . ' +1 day'));
            }

            $totalUsageThisWeek = $logs->count();
            $totalUsageLastWeek = Logs::all()->filter(function ($item) use ($firstDayOfLastWeek, $lastDayOfLastWeek) {
                return ($item['created_at'] >= $firstDayOfLastWeek && $item['created_at'] <= $lastDayOfLastWeek) ||
                       ($item['updated_at'] >= $firstDayOfLastWeek && $item['updated_at'] <= $lastDayOfLastWeek);
            })->count();

            if($totalUsageLastWeek != 0){
                $percentageChangeInUsage = (($totalUsageThisWeek - $totalUsageLastWeek) / $totalUsageLastWeek) * 100;
            }else{
                $percentageChangeInUsage = $totalUsageThisWeek * 100;
            }

            // an admin
            return view('dashboard.admin', compact('teachers', 'facilitators', 'schools', 'lessonPlans', 'steps', 'logsPerDay', 'percentageChangeInUsage'));

        }else{
            //a teacher
            $teachers = User::all()->where('role', 'Teacher');
            $facilitators = User::all()->where('role', 'Facilitator');
            $schools = School::all();
            $subjects = Subject::all();
            $lessonPlans = LessonPlan::all();
            $yourLPs = LessonPlan::all()->where('owner', auth()->user()->id);
            $yourApprovedLPs = LessonPlan::all()->where('owner', auth()->user()->id)
                                        ->where('status', 'approved');
            $steps = LessonStep::all();

            // an admin
            return view('dashboard.teacher', compact('teachers', 'facilitators', 'schools', 'subjects', 'lessonPlans', 'yourLPs', 'yourApprovedLPs', 'steps'));
        }
    }
}
