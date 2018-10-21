<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Summoner extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'champion_name' =>'http://ddragon.leagueoflegends.com/cdn/8.20.1/img/champion/'.str_replace("'", '', str_replace(' ', '',$this->championName)).'.png',
            '# of games' =>$this->num_games,
            'avg gold at 10m' => self::readable($this->gold_at_10),
            'avg game duration' => gmdate("H:i:s", $this->game_duration),
            'avg KDA' => self::readable($this->kda),
            'winrate' => self::readable($this->winrate*100).'%'
        ];
    }

    public function readable($number){
        return number_format((float)$number, 2, '.', '');
    }
}
