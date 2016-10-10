<?php

namespace Pi\Clients\Theme;

use Pi\Domain\Model;

use Codesleeve\Stapler\ORM\StaplerableInterface;
use Codesleeve\Stapler\ORM\EloquentTrait;


/**
 * Pi\Clients\Theme\Theme
 *
 * @property integer $id
 * @property string $font
 * @property string $nav_color
 * @property string $back_color
 * @property string $style_type
 * @property string $style_name
 * @property string $logo_file_name
 * @property integer $logo_file_size
 * @property string $logo_content_type
 * @property string $logo_updated_at
 * @property string $background_file_name
 * @property integer $background_file_size
 * @property string $background_content_type
 * @property string $background_updated_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Theme\Theme whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Theme\Theme whereFont($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Theme\Theme whereNavColor($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Theme\Theme whereBackColor($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Theme\Theme whereStyleType($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Theme\Theme whereStyleName($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Theme\Theme whereLogoFileName($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Theme\Theme whereLogoFileSize($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Theme\Theme whereLogoContentType($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Theme\Theme whereLogoUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Theme\Theme whereBackgroundFileName($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Theme\Theme whereBackgroundFileSize($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Theme\Theme whereBackgroundContentType($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Theme\Theme whereBackgroundUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Theme\Theme whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Pi\Clients\Theme\Theme whereUpdatedAt($value)
 */
class Theme extends Model implements StaplerableInterface
{
    use EloquentTrait;

    public function __construct(array $attributes = [])
    {
        $this->hasAttachedFile('logo', [
            'styles' => [
                'mini' => '50x50',
                'medium' => '128x128'
            ],
            'default_url' => '/assets/img/logo.png',
        ]);

        $this->hasAttachedFile('background');

        parent::__construct($attributes);
    }

    /**
     * @return bool
     */
    public function hasLogo()
    {
        return $this->logo->originalFilename();
    }

    /**
     * @return bool
     */
    public function hasBackground()
    {
        return $this->background->originalFilename();
    }

    public static function getAvailableFonts()
    {
        return [
            'Open Sans' => 'Open Sans',
            'Helvetica Neue' => 'Helvetica Neue',
            'Arial' => 'Arial',
        ];
    }


    public static function getStyleNames()
    {
        return [
            'theme-navy' => 'Standard',
            'theme-light' => 'Light',
            'theme-ocean' => 'Ocean',
            'theme-lime' => 'Lime',
            'theme-purple' => 'Purple',
            'theme-dust' => 'Dust',
            'theme-mint' => 'Mint',
            'theme-yellow' => 'Yellow',
            'theme-well-red' => 'Well Red',
            'theme-coffee' => 'Coffee',
            'theme-dark' => 'Dark',
            'theme-p4' => 'P4'
        ];
    }

    public static function getStyleTypes()
    {
        return [
            'a' => 'A style',
            'b' => 'B style',
            'c' => 'C style',
        ];
    }
}