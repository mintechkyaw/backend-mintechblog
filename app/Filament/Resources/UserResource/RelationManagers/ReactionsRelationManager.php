<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ReactionsRelationManager extends RelationManager
{
    protected static string $relationship = 'reactions';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('react_type')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('post.title'),
                Tables\Columns\TextColumn::make('react_type'),
                Tables\Columns\IconColumn::make('react_type')->icon(fn (string $state): string => match ($state) {
                    'like' => 'heroicon-o-hand-thumb-up',
                    'love' => 'heroicon-o-heart',
                })->color(fn (string $state): string => match ($state) {
                    'like' => 'info',
                    'love' => 'danger'
                }),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('post')->relationship('post', 'title')->multiple()->preload()
            ])
            ->actions([
                //
            ])
            ->bulkActions([
                //
            ]);
    }
}
