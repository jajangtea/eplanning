<?php

namespace App\Models\Renstra;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class RenstraVisiModel extends Model {
    use LogsActivity;
     /**
     * nama tabel model ini.
     *
     * @var string
     */
    protected $table = 'renstravisi';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'replace_it', 'replace_it'
    ];
    /**
     * primary key tabel ini.
     *
     * @var string
     */
    protected $primaryKey = 'renstravisi_id';
    /**
     * enable auto_increment.
     *
     * @var string
     */
    public $incrementing = true;
    /**
     * activated timestamps.
     *
     * @var string
     */
    public $timestamps = true;

    /**
     * make the model use another name than the default
     *
     * @var string
     */
    // protected static $logName = 'RenstraVisiController';
    /**
     * log the changed attributes for all these events 
     */
    // protected static $logAttributes = ['replace_it', 'replace_it'];
    /**
     * log changes to all the $fillable attributes of the model
     */
    // protected static $logFillable = true;

    //only the `deleted` event will get logged automatically
    // protected static $recordEvents = ['deleted'];
}
