<?php

namespace App\Filament\Resources\CategoryResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class PostsRelationManager extends RelationManager
{
    protected static string $relationship = 'posts';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()->schema([
                    Forms\Components\Section::make([
                        Forms\Components\TextInput::make('title')->required()->unique('posts', 'title', ignoreRecord: true),
                        Forms\Components\FileUpload::make('image')->image()->label('')->required()

                        ])
                ]),
                Forms\Components\Group::make()->schema([
                    Forms\Components\Section::make('Other Details')->schema([
                        Forms\Components\Select::make('category')
                        ->label('Category')->relationship('categories', 'name')
                            ->multiple()->required()
                            ->preload(),
                    ])
                ])
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image'),
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('published_at')
                ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')->label('edited_at')
                ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('category')->relationship('categories', 'name')->multiple()->preload()
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
