<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Champion;

class Opponent extends JsonResource
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
            'champion' =>["text" =>$champ->champion_name, "src" => $champ->portrait_url],
            '# of games' =>$this->num_games,
            'avg gold at 10m' => self::readable($this->gold_at_10),
            'avg gold at 10m (opponent\')' => self::readable($this->gold_at_10_opponent),
            'delta goldat 10m' => self::readable($this->gold_at_10_opponent),
            'avg game duration' => gmdate("H:i:s", $this->game_duration),
            'avg KDA' => self::readable($this->kda),
            'avg KDA (opponent\')' => self::readable($this->kda),
            'winrate' => self::readable($this->winrate*100).'%'
        ];
    }

    public function readable($number){
        return number_format((float)$number, 2, '.', '');
    }
}
