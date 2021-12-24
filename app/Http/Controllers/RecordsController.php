<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RecordsController extends Controller
{
    public function GetMapRecord(Request $request, $MapId) {
        $mainRecords = DB::select(
            "SELECT 
                PlayerTiming.Id, PlayerTiming.MapId, PlayerTiming.PlayerId, PlayerJoin.Name, PlayerTiming.StyleId, PlayerTiming.Level, PlayerTiming.Type, PlayerTiming.Tickrate, PlayerTiming.Time, PlayerTiming.Rank, PlayerTiming.TimeInZone, PlayerTiming.Attempts, PlayerTiming.Sync, PlayerTiming.Speed, PlayerTiming.Jumps, PlayerTiming.Status,
                PlayerTimingInsightJoin.StartPositionX, PlayerTimingInsightJoin.StartPositionY, PlayerTimingInsightJoin.StartPositionZ,
                PlayerTimingInsightJoin.EndPositionX, PlayerTimingInsightJoin.EndPositionY, PlayerTimingInsightJoin.EndPositionZ,
                PlayerTimingInsightJoin.StartAngleX, PlayerTimingInsightJoin.StartAngleY, PlayerTimingInsightJoin.StartAngleZ,
                PlayerTimingInsightJoin.EndAngleX, PlayerTimingInsightJoin.EndAngleY, PlayerTimingInsightJoin.EndAngleZ,
                PlayerTimingInsightJoin.StartVelocityX, PlayerTimingInsightJoin.StartVelocityY, PlayerTimingInsightJoin.StartVelocityZ,
                PlayerTimingInsightJoin.EndVelocityX, PlayerTimingInsightJoin.EndVelocityY, PlayerTimingInsightJoin.EndVelocityZ
            FROM PlayerTiming PlayerTiming
            JOIN Player AS PlayerJoin ON PlayerJoin.Id = PlayerTiming.PlayerId
            JOIN PlayerTimingInsight AS PlayerTimingInsightJoin ON PlayerTiming.Id = PlayerTimingInsightJoin.PlayerTimingId
            INNER JOIN (
                SELECT Level, StyleId, min(Time) AS BestTime
                FROM PlayerTiming
                GROUP BY Level, StyleId
            ) PlayerTimingInnerJoin ON PlayerTiming.Level = PlayerTimingInnerJoin.Level AND PlayerTiming.StyleId AND PlayerTimingInnerJoin.StyleId AND PlayerTiming.Time = PlayerTimingInnerJoin.BestTime
            WHERE PlayerTiming.MapId = " . $MapId . " AND PlayerTiming.Status = 1;"
        );

        $this->checkExists($mainRecords);

        $detailedRecords = [];

        foreach ($mainRecords as $mainRecord) {
            # Checkpoint/Stage Start
            $addRecords = null;

            if ($mainRecord->Type == 'Stage') {
                $addRecords = DB::table('PlayerTimingStage')
                        ->join('PlayerTimingStageInsight', 'PlayerTimingStage.Id', '=', 'PlayerTimingStageInsight.PlayerTimingStageId')
                        ->select('PlayerTimingStage.Id', 'PlayerTimingStage.Stage', 'PlayerTimingStage.Time', 'PlayerTimingStage.TimeInZone', 'PlayerTimingStage.Attempts', 'PlayerTimingStage.Sync', 'PlayerTimingStage.Speed', 'PlayerTimingStage.Jumps',
                                'PlayerTimingStageInsight.StartPositionX', 'PlayerTimingStageInsight.StartPositionY', 'PlayerTimingStageInsight.StartPositionZ',
                                'PlayerTimingStageInsight.EndPositionX', 'PlayerTimingStageInsight.EndPositionY', 'PlayerTimingStageInsight.EndPositionZ',
                                'PlayerTimingStageInsight.StartAngleX', 'PlayerTimingStageInsight.StartAngleY', 'PlayerTimingStageInsight.StartAngleZ',
                                'PlayerTimingStageInsight.EndAngleX', 'PlayerTimingStageInsight.EndAngleY', 'PlayerTimingStageInsight.EndAngleZ',
                                'PlayerTimingStageInsight.StartVelocityX', 'PlayerTimingStageInsight.StartVelocityY', 'PlayerTimingStageInsight.StartVelocityZ',
                                'PlayerTimingStageInsight.EndVelocityX', 'PlayerTimingStageInsight.EndVelocityY', 'PlayerTimingStageInsight.EndVelocityZ' )
                        ->where('PlayerTimingStage.PlayerTimingId', $mainRecord->Id)
                        ->orderBy('Stage', 'asc')
                        ->get();

                $this->checkExists($addRecords);
            }
            else if ($mainRecord->Type == 'Checkpoint') {
                $addRecords = DB::table('PlayerTimingCheckpoint')
                        ->join('PlayerTimingCheckpointInsight', 'PlayerTimingCheckpoint.Id', '=', 'PlayerTimingCheckpointInsight.PlayerTimingCheckpointId')
                        ->select('PlayerTimingCheckpoint.Id', 'PlayerTimingCheckpoint.Checkpoint', 'PlayerTimingCheckpoint.Time', 'PlayerTimingCheckpoint.Sync', 'PlayerTimingCheckpoint.Speed', 'PlayerTimingCheckpoint.Jumps',
                                'PlayerTimingCheckpointInsight.PositionX', 'PlayerTimingCheckpointInsight.PositionY', 'PlayerTimingCheckpointInsight.PositionZ',
                                'PlayerTimingCheckpointInsight.AngleX', 'PlayerTimingCheckpointInsight.AngleY', 'PlayerTimingCheckpointInsight.AngleZ',
                                'PlayerTimingCheckpointInsight.VelocityX', 'PlayerTimingCheckpointInsight.VelocityY', 'PlayerTimingCheckpointInsight.VelocityZ')
                        ->where('PlayerTimingCheckpoint.PlayerTimingId', $mainRecord->Id)
                        ->orderBy('Checkpoint', 'asc')
                        ->get();

                $this->checkExists($addRecords);
            }

            $addRecords = (array)$addRecords;
            $mainRecord = (array)$mainRecord;

            $mainRecord = array_merge($mainRecord, $addRecords);
            $mainRecord = str_replace('\\u0000', '', json_encode($mainRecord));
            $mainRecord = json_decode($mainRecord);
            # Checkpoint/Stage End

            array_push($detailedRecords, $mainRecord);
        }

        return response()->json($detailedRecords);
    }

    public function GetMapRecordsCount(Request $request, $MapId) {
        $counts = DB::select(
            "SELECT 
                StyleId, Level, COUNT(Time) AS Count
            FROM PlayerTiming
            WHERE MapId = " . $MapId . " AND Status = 1
            GROUP BY StyleId, Level;"
        );

        $this->checkExists($counts);

        return response()->json($counts);
    }

    public function GetMapRecordsAvgTime(Request $request, $MapId) {
        $avgs = DB::select(
            "SELECT 
                StyleId, Level, AVG(Time) AS AvgTime
            FROM PlayerTiming
            WHERE MapId = " . $MapId . " AND Status = 1
            GROUP BY StyleId, Level;"
        );

        $this->checkExists($avgs);

        return response()->json($avgs);
    }

    public function GetMapPlayerRecord(Request $request, $MapId, $PlayerId) {
        $mainRecords = DB::select(
            "SELECT 
                PlayerTiming.Id, PlayerTiming.MapId, PlayerTiming.PlayerId, PlayerJoin.Name, PlayerTiming.StyleId, PlayerTiming.Level, PlayerTiming.Type, PlayerTiming.Tickrate, PlayerTiming.Time, PlayerTiming.Rank, PlayerTiming.TimeInZone, PlayerTiming.Attempts, PlayerTiming.Sync, PlayerTiming.Speed, PlayerTiming.Jumps, PlayerTiming.Status,
                PlayerTimingInsightJoin.StartPositionX, PlayerTimingInsightJoin.StartPositionY, PlayerTimingInsightJoin.StartPositionZ,
                PlayerTimingInsightJoin.EndPositionX, PlayerTimingInsightJoin.EndPositionY, PlayerTimingInsightJoin.EndPositionZ,
                PlayerTimingInsightJoin.StartAngleX, PlayerTimingInsightJoin.StartAngleY, PlayerTimingInsightJoin.StartAngleZ,
                PlayerTimingInsightJoin.EndAngleX, PlayerTimingInsightJoin.EndAngleY, PlayerTimingInsightJoin.EndAngleZ,
                PlayerTimingInsightJoin.StartVelocityX, PlayerTimingInsightJoin.StartVelocityY, PlayerTimingInsightJoin.StartVelocityZ,
                PlayerTimingInsightJoin.EndVelocityX, PlayerTimingInsightJoin.EndVelocityY, PlayerTimingInsightJoin.EndVelocityZ
            FROM PlayerTiming PlayerTiming
            JOIN Player AS PlayerJoin ON PlayerJoin.Id = PlayerTiming.PlayerId
            JOIN PlayerTimingInsight AS PlayerTimingInsightJoin ON PlayerTiming.Id = PlayerTimingInsightJoin.PlayerTimingId
            INNER JOIN (
                SELECT Level, StyleId, min(Time) AS BestTime
                FROM PlayerTiming
                GROUP BY Level, StyleId
            ) PlayerTimingInnerJoin ON PlayerTiming.Level = PlayerTimingInnerJoin.Level AND PlayerTiming.StyleId AND PlayerTimingInnerJoin.StyleId AND PlayerTiming.Time = PlayerTimingInnerJoin.BestTime
            WHERE PlayerTiming.MapId = " . $MapId . " AND PlayerTiming.PlayerId = " . $PlayerId . " AND PlayerTiming.Status = 1;"
        );

        $this->checkExists($mainRecords);

        $detailedRecords = [];

        foreach ($mainRecords as $mainRecord) {
            # Checkpoint/Stage Start
            $addRecords = null;

            if ($mainRecord->Type == 'Stage') {
                $addRecords = DB::table('PlayerTimingStage')
                                    ->join('PlayerTimingStageInsight', 'PlayerTimingStage.Id', '=', 'PlayerTimingStageInsight.PlayerTimingStageId')
                                    ->select('PlayerTimingStage.Id', 'PlayerTimingStage.Stage', 'PlayerTimingStage.Time', 'PlayerTimingStage.TimeInZone', 'PlayerTimingStage.Attempts', 'PlayerTimingStage.Sync', 'PlayerTimingStage.Speed', 'PlayerTimingStage.Jumps',
                                            'PlayerTimingStageInsight.StartPositionX', 'PlayerTimingStageInsight.StartPositionY', 'PlayerTimingStageInsight.StartPositionZ',
                                            'PlayerTimingStageInsight.EndPositionX', 'PlayerTimingStageInsight.EndPositionY', 'PlayerTimingStageInsight.EndPositionZ',
                                            'PlayerTimingStageInsight.StartAngleX', 'PlayerTimingStageInsight.StartAngleY', 'PlayerTimingStageInsight.StartAngleZ',
                                            'PlayerTimingStageInsight.EndAngleX', 'PlayerTimingStageInsight.EndAngleY', 'PlayerTimingStageInsight.EndAngleZ',
                                            'PlayerTimingStageInsight.StartVelocityX', 'PlayerTimingStageInsight.StartVelocityY', 'PlayerTimingStageInsight.StartVelocityZ',
                                            'PlayerTimingStageInsight.EndVelocityX', 'PlayerTimingStageInsight.EndVelocityY', 'PlayerTimingStageInsight.EndVelocityZ' )
                                    ->where('PlayerTimingStage.PlayerTimingId', $mainRecord->Id)
                                    ->orderBy('Stage', 'asc')
                                    ->get();

                $this->checkExists($addRecords);
            }
            else if ($mainRecord->Type == 'Checkpoint') {
                $addRecords = DB::table('PlayerTimingCheckpoint')
                                    ->join('PlayerTimingCheckpointInsight', 'PlayerTimingCheckpoint.Id', '=', 'PlayerTimingCheckpointInsight.PlayerTimingCheckpointId')
                                    ->select('PlayerTimingCheckpoint.Id', 'PlayerTimingCheckpoint.Checkpoint', 'PlayerTimingCheckpoint.Time', 'PlayerTimingCheckpoint.Sync', 'PlayerTimingCheckpoint.Speed', 'PlayerTimingCheckpoint.Jumps',
                                            'PlayerTimingCheckpointInsight.PositionX', 'PlayerTimingCheckpointInsight.PositionY', 'PlayerTimingCheckpointInsight.PositionZ',
                                            'PlayerTimingCheckpointInsight.AngleX', 'PlayerTimingCheckpointInsight.AngleY', 'PlayerTimingCheckpointInsight.AngleZ',
                                            'PlayerTimingCheckpointInsight.VelocityX', 'PlayerTimingCheckpointInsight.VelocityY', 'PlayerTimingCheckpointInsight.VelocityZ')
                                    ->where('PlayerTimingCheckpoint.PlayerTimingId', $mainRecord->Id)
                                    ->orderBy('Checkpoint', 'asc')
                                    ->get();

                $this->checkExists($addRecords);
            }

            $addRecords = (array)$addRecords;
            $mainRecord = (array)$mainRecord;

            $mainRecord = array_merge($mainRecord, $addRecords);
            $mainRecord = str_replace('\\u0000', '', json_encode($mainRecord));
            $mainRecord = json_decode($mainRecord);
            # Checkpoint/Stage End

            array_push($detailedRecords, $mainRecord);
        }

        return response()->json($detailedRecords);
    }

    public function InsertRecord(Request $request) {
        try {
            $PlayerTimingId = DB::table('PlayerTiming')->insertGetId([
                'MapId' => $request->MapId,
                'PlayerId' => $request->PlayerId,
                'StyleId' => $request->StyleId,
                'Level' => $request->Level,
                'Type' => $request->Type,
                'Tickrate' => $request->Tickrate,
                'Time' => $request->Time,
                'TimeInZone' => $request->TimeInZone,
                'Attempts' => $request->Attempts,
                'Sync' => $request->Sync,
                'Speed' => $request->Speed,
                'Jumps' => $request->Jumps
            ]);

            DB::table('PlayerTimingInsight')->insert([
                'PlayerTimingId' => $PlayerTimingId,
                'StartPositionX' => $request->StartPositionX,
                'StartPositionY' => $request->StartPositionY,
                'StartPositionZ' => $request->StartPositionZ,
                'EndPositionX' => $request->EndPositionX,
                'EndPositionY' => $request->EndPositionY,
                'EndPositionZ' => $request->EndPositionZ,
                'StartAngleX' => $request->StartAngleX,
                'StartAngleY' => $request->StartAngleY,
                'StartAngleZ' => $request->StartAngleZ,
                'EndAngleX' => $request->EndAngleX,
                'EndAngleY' => $request->EndAngleY,
                'EndAngleZ' => $request->EndAngleZ,
                'StartVelocityX' => $request->StartVelocityX,
                'StartVelocityY' => $request->StartVelocityY,
                'StartVelocityZ' => $request->StartVelocityZ,
                'EndVelocityX' => $request->EndVelocityX,
                'EndVelocityY' => $request->EndVelocityY,
                'EndVelocityZ' => $request->EndVelocityZ
            ]);

            if ($request->Type == "Stage") {
                foreach ($request->Details as $record) {
                    $PlayerTimingStageId = DB::table('PlayerTimingStage')->insertGetId([
                        'PlayerTimingId' => $PlayerTimingId,
                        'Stage' => $record['Stage'],
                        'Time' => $record['Time'],
                        'TimeInZone' => $record['TimeInZone'],
                        'Attempts' => $record['Attempts'],
                        'Sync' => $record['Sync'],
                        'Speed' => $record['Speed'],
                        'Jumps' => $record['Jumps']
                    ]);

                    DB::table('PlayerTimingStageInsight')->insert([
                        'PlayerTimingStageId' => $PlayerTimingStageId,
                        'StartPositionX' => $record['StartPositionX'],
                        'StartPositionY' => $record['StartPositionY'],
                        'StartPositionZ' => $record['StartPositionZ'],
                        'EndPositionX' => $record['EndPositionX'],
                        'EndPositionY' => $record['EndPositionY'],
                        'EndPositionZ' => $record['EndPositionZ'],
                        'StartAngleX' => $record['StartAngleX'],
                        'StartAngleY' => $record['StartAngleY'],
                        'StartAngleZ' => $record['StartAngleZ'],
                        'EndAngleX' => $record['EndAngleX'],
                        'EndAngleY' => $record['EndAngleY'],
                        'EndAngleZ' => $record['EndAngleZ'],
                        'StartVelocityX' => $record['StartVelocityX'],
                        'StartVelocityY' => $record['StartVelocityY'],
                        'StartVelocityZ' => $record['StartVelocityZ'],
                        'EndVelocityX' => $record['EndVelocityX'],
                        'EndVelocityY' => $record['EndVelocityY'],
                        'EndVelocityZ' => $record['EndVelocityZ']
                    ]);
                }
            }
            else if ($request->Type == "Checkpoint") {
                foreach ($request->Details as $record) {
                    $PlayerTimingCheckpointId = DB::table('PlayerTimingCheckpoint')->insertGetId([
                        'PlayerTimingId' => $PlayerTimingId,
                        'Checkpoint' => $record['Checkpoint'],
                        'Time' => $record['Time'],
                        'Sync' => $record['Sync'],
                        'Speed' => $record['Speed'],
                        'Jumps' => $record['Jumps']
                    ]);

                    DB::table('PlayerTimingCheckpointInsight')->insert([
                        'PlayerTimingCheckpointId' => $PlayerTimingCheckpointId,
                        'PositionX' => $record['PositionX'],
                        'PositionY' => $record['PositionY'],
                        'PositionZ' => $record['PositionZ'],
                        'AngleX' => $record['AngleX'],
                        'AngleY' => $record['AngleY'],
                        'AngleZ' => $record['AngleZ'],
                        'VelocityX' => $record['VelocityX'],
                        'VelocityY' => $record['VelocityY'],
                        'VelocityZ' => $record['VelocityZ']
                    ]);
                }
            }
        }
        catch (\Illuminate\Database\QueryException $e) {
            return response()->json("Duplicate entry", 409);
        }

        return response()->json($request, 201);
    }

    public function UpdateRecord(Request $request) {
        $PlayerTiming = DB::table('PlayerTiming')
                                ->select('Id', 'Type')
                                ->where('MapId', $request->MapId)
                                ->where('PlayerId', $request->PlayerId)
                                ->where('StyleId', $request->StyleId)
                                ->where('Level', $request->Level)
                                ->first();

        DB::table('PlayerTiming')->where('Id', $PlayerTiming->Id)->update([
            'Time' => $request->Time,
            'TimeInZone' => $request->TimeInZone,
            'Attempts' => $request->Attempts,
            'Sync' => $request->Sync,
            'Speed' => $request->Speed,
            'Jumps' => $request->Jumps
        ]);

        DB::table('PlayerTimingInsight')->where('PlayerTimingId', $PlayerTiming->Id)->update([
            'StartPositionX' => $request->StartPositionX,
            'StartPositionY' => $request->StartPositionY,
            'StartPositionZ' => $request->StartPositionZ,
            'EndPositionX' => $request->EndPositionX,
            'EndPositionY' => $request->EndPositionY,
            'EndPositionZ' => $request->EndPositionZ,
            'StartAngleX' => $request->StartAngleX,
            'StartAngleY' => $request->StartAngleY,
            'StartAngleZ' => $request->StartAngleZ,
            'EndAngleX' => $request->EndAngleX,
            'EndAngleY' => $request->EndAngleY,
            'EndAngleZ' => $request->EndAngleZ,
            'StartVelocityX' => $request->StartVelocityX,
            'StartVelocityY' => $request->StartVelocityY,
            'StartVelocityZ' => $request->StartVelocityZ,
            'EndVelocityX' => $request->EndVelocityX,
            'EndVelocityY' => $request->EndVelocityY,
            'EndVelocityZ' => $request->EndVelocityZ
        ]);

        if ($request->Type == "Stage") {
            foreach ($request->Details as $record) {
                $PlayerTimingStage = DB::table('PlayerTimingStage')
                                ->select('Id')
                                ->where('PlayerTimingId', $PlayerTiming->Id)
                                ->where('Stage', $record['Stage'])
                                ->first();

                DB::table('PlayerTimingStage')->where('Id', $PlayerTimingStage->Id)->update([
                    'Time' => $record['Time'],
                    'TimeInZone' => $record['TimeInZone'],
                    'Attempts' => $record['Attempts'],
                    'Sync' => $record['Sync'],
                    'Speed' => $record['Speed'],
                    'Jumps' => $record['Jumps']
                ]);

                DB::table('PlayerTimingStageInsight')->where('Id', $PlayerTimingStage->Id)->update([
                    'StartPositionX' => $record['StartPositionX'],
                    'StartPositionY' => $record['StartPositionY'],
                    'StartPositionZ' => $record['StartPositionZ'],
                    'EndPositionX' => $record['EndPositionX'],
                    'EndPositionY' => $record['EndPositionY'],
                    'EndPositionZ' => $record['EndPositionZ'],
                    'StartAngleX' => $record['StartAngleX'],
                    'StartAngleY' => $record['StartAngleY'],
                    'StartAngleZ' => $record['StartAngleZ'],
                    'EndAngleX' => $record['EndAngleX'],
                    'EndAngleY' => $record['EndAngleY'],
                    'EndAngleZ' => $record['EndAngleZ'],
                    'StartVelocityX' => $record['StartVelocityX'],
                    'StartVelocityY' => $record['StartVelocityY'],
                    'StartVelocityZ' => $record['StartVelocityZ'],
                    'EndVelocityX' => $record['EndVelocityX'],
                    'EndVelocityY' => $record['EndVelocityY'],
                    'EndVelocityZ' => $record['EndVelocityZ']
                ]);
            }
        }
        else if ($request->Type == "Checkpoint") {
            foreach ($request->Details as $record) {
                $PlayerTimingCheckpoint = DB::table('PlayerTimingCheckpoint')
                                ->select('Id')
                                ->where('PlayerTimingId', $PlayerTiming->Id)
                                ->where('Checkpoint', $record['Checkpoint'])
                                ->first();

                DB::table('PlayerTimingCheckpoint')->where('Id', $PlayerTimingCheckpoint->Id)->update([
                    'Time' => $record['Time'],
                    'Sync' => $record['Sync'],
                    'Speed' => $record['Speed'],
                    'Jumps' => $record['Jumps']
                ]);

                DB::table('PlayerTimingCheckpointInsight')->where('Id', $PlayerTimingCheckpoint->Id)->update([
                    'PositionX' => $record['PositionX'],
                    'PositionY' => $record['PositionY'],
                    'PositionZ' => $record['PositionZ'],
                    'AngleX' => $record['AngleX'],
                    'AngleY' => $record['AngleY'],
                    'AngleZ' => $record['AngleZ'],
                    'VelocityX' => $record['VelocityX'],
                    'VelocityY' => $record['VelocityY'],
                    'VelocityZ' => $record['VelocityZ']
                ]);
            }
        }

        return response()->json('OK');
    }

    public function DeleteRecordByPlayerTimingId(Request $request, $PlayerTimingId)
    {
        DB::table('PlayerTiming')->where('Id', $PlayerTimingId)->delete();

        return response()->json('OK');
    }
}
