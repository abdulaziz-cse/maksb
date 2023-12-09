<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\Avatar;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Platform extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Platform>
     */
    public static $model = \App\Models\Platform::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id','name'
    ];

    public static $with = ['logo'];


    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),
            Text::make('Name')->sortable()->required()->showOnPreview(),
            Avatar::make('Image')->squared()
                ->store(function (Request $request, $model) {
                    $model->addMediaFromRequest('image')->toMediaCollection('platforms');
                    return true;
                })
                ->preview(function () {
                    return $this->getFirstMediaUrl('platforms', 'small');
                })
                ->thumbnail(function () {
                    return $this->getFirstMediaUrl('platforms', 'small');
                })
                ->download(function() {
                    return $this->logo;
                })
                ->delete(function () {
                    $this->media()->delete();
                    return true;
                }),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [];
    }

    public function authorizedToDelete(Request $request)
    {
        return false;
    }
}
