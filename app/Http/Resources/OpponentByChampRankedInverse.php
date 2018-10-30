<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Champion;

class OpponentByChampRankedInverse extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $champ = Champion::find($this->champion_id);
        return [
            'champion' =>["text" =>$champ->champion_name, "src" => $champ->portrait_url , "id" => $champ->id],
            '# of games' =>$this->num_games,
            'avg gold at 10m' => self::readable($this->gold_at_10),
            'avg gold at 10m (opponent\')' => self::readable($this->gold_at_10_opponent),
            'delta goldat 10m' => self::readable($this->delta_gold_at_10),
            'avg game duration' => gmdate("H:i:s", $this->game_duration),
            'avg KDA' => self::readable($this->kda),
            'avg KDA (opponent\')' => self::readable($this->kda_opponent),
            'winrate %' => self::readable($this->winrate*100)
        ];
    }

    public function readable($number){
        return number_format((float)$number, 2, '.', '');
    }
}
