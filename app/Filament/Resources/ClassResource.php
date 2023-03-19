<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClassResource\Pages;
use App\Filament\Resources\ClassResource\RelationManagers;
use App\Models\ClassModel;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ClassResource extends Resource
{
    protected static ?string $model = ClassModel::class;

    protected static ?string $modelLabel = 'Class';

    protected static ?string $slug = 'classes';

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('class_name')->required(),
                Forms\Components\TextInput::make('mentor')->required(),
                Forms\Components\TextInput::make('strength')->required(),
                Forms\Components\Select::make('department_id')->relationship('department', 'department_name')->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('class_name')->searchable(),
                Tables\Columns\TextColumn::make('mentor')->searchable(),
                Tables\Columns\TextColumn::make('strength')->sortable(),
                Tables\Columns\TextColumn::make('department.department_name')->searchable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('department_name')->relationship('department', 'department_name'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
    
    public static function getRelations(): array
    {
        return [
            RelationManagers\RecordsRelationManager::class,
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListClasses::route('/'),
            'create' => Pages\CreateClass::route('/create'),
            'edit' => Pages\EditClass::route('/{record}/edit'),
        ];
    }    
}
