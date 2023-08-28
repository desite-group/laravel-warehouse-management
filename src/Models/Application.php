<?php

namespace DesiteGroup\LaravelNovaUaVolunteersWarehouseManagement\Models;

use Database\Factories\ApplicationsFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Translatable\HasTranslations;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Application extends Model implements Sortable, HasMedia
{
    use HasFactory, InteractsWithMedia, SortableTrait;

    const types = [
        'military'      => 'Військової Частини',
        'organization'  => 'Організації',
        'person'        => 'фізичної особи (у т.ч. військовослужбовця)'
    ];

    const links = [
        'military'          => [
            'google_dock'   => 'https://docs.google.com/document/d/1h-NDCGVQLlbk3IIeZpXwdKmbcmjfsuKxKl1TPacyjLs',
            'file'          => '/files/military.docx'
        ],
        'organization'      => [
            'google_dock'   => 'https://docs.google.com/document/d/1lZ_gjlVtiK53INY303xiRyy7oV0PBMq4gVZ5DuPwv8E',
            'file'          => '/files/organization.docx'
        ],
        'person'            => [
            'google_dock'   => 'https://docs.google.com/document/d/13Wbg4iDUa17k5N48GqZP2qoPvYv6IwhE7z30U3n2Xfo',
            'file'          => '/files/person.docx'
        ]
    ];

    protected $fillable = [
        'document_number', 'organization',
        'organization_address', 'organization_chief',
        'organization_registration', 'phone', 'recipient',
        'additional_text', 'internal_comment', 'type', 'needs'
    ];

    public $sortable = [
        'order_column_name' => 'sort_order',
        'sort_when_creating' => true,
    ];

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory(): Factory
    {
        return ApplicationsFactory::new();
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('main')
            ->format(Manipulations::FORMAT_JPG)
            ->fit(Manipulations::FIT_MAX, 800, 800)
            ->performOnCollections('photo');

        $this->addMediaConversion('thumb_main')
            ->format(Manipulations::FORMAT_JPG)
            ->fit(Manipulations::FIT_MAX, 20, 20)
            ->performOnCollections('photo');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('photo')->singleFile();
        $this->addMediaCollection('documents');
    }

    public static function getTypeByCode(?string $code): ?string
    {
        return self::types[$code] ?? null;
    }

    public static function getFileLinkByCode(?string $code): ?array
    {
        return self::links[$code] ?? null;
    }


    public static function createFromBot(array $data): self
    {
        $model = new self;
        $model->organization = Arr::get($data, 'recipient');
        $model->organization_chief = Arr::get($data, 'recipient_person');
        $model->organization_registration = Arr::get($data, 'registration_data');
        $model->recipient = Arr::get($data, 'contact_person');
        $model->phone = Arr::get($data, 'contact_phone');
        $model->additional_text = Arr::get($data, 'description');
        $model->type = Arr::get($data, 'type');

        return $model;
    }
}
