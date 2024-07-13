<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CommentsRelationManager extends RelationManager
{
    protected static string $relationship = 'comments';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('comment')
                    ->required()
                    ->maxLength(255)->columnSpanFull(true),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('comment')
            ->columns([
                Tables\Columns\TextColumn::make('user.name'),
                Tables\Columns\TextColumn::make('comment'),
                Tables\Columns\IconColumn::make('created_at')->label('Edited')
                    ->icon(fn ($record) => $record->created_at === $record->updated_at ? 'heroicon-o-check-circle' : 'heroicon-o-x-circle')
                    ->color(fn ($record) => $record->created_at === $record->updated_at ? 'success' : 'danger'),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('post.title')->relationship('post', 'title')->multiple()->preload()
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
            ])
            ->bulkActions([
                //
            ]);
    }
}
