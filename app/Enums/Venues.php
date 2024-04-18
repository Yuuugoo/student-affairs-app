<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum Venues: string implements HasLabel
{
    case JAA = 'jaa';
    case BTB = 'btb';
    case FOH = 'foh';
    case ACC = 'acc';
    case EVR = 'evr';
    case BVR = 'bvr';
    case UGY = 'ugy';
    case UAC = 'uac';
    case TBF = 'tbf';
    case MNG = 'mng';
    case PRG = 'prg';
    case PR2 = 'pr2';
    case FAC = 'fac';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::JAA => 'Justo Albert Auditorium (JAA), Gusaling Lacson',
            self::BTB => 'Bukod Tanging Bulwagan (BTB), Gusaling Katipunan',
            self::FOH => 'Forum Hall, Gusaling Bigasing',
            self::ACC => 'Accenture, Gusaling Villegas',
            self::EVR => 'GEE AVR, Gusaling Emilio Ejercito',
            self::BVR => 'AVR, 3rd floor, Gusaling Bagatsing',
            self::UGY => 'University Gymnasium',
            self::UAC => 'University Activity Center (UAC)',
            self::TBF => 'Tanghalang Bayan (TB) & University Field',
            self::MNG => 'Mangahan (UTMT)',
            self::PRG => 'PRMEC, Ground Floor',
            self::PR2 => 'PRMEC, 2nd floor',
            self::FAC => 'PLM Facade',


        };
    }

}