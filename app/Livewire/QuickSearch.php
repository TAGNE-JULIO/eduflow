<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;

class QuickSearch extends Component
{
    public $query = '';
    public $isOpen = false;

    protected $listeners = ['openQuickSearch' => 'openModal'];

    public function openModal()
    {
        $this->isOpen = true;
        $this->query = '';
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->query = '';
    }

    public function render()
    {
        $results = [];
        $navLinks = [
            ['title' => __('Tableau de bord'), 'url' => route('dashboard'), 'icon' => 'fas fa-tachometer-alt', 'category' => __('Navigation')],
            ['title' => __('Messagerie Interne'), 'url' => route('messages.index'), 'icon' => 'fas fa-envelope', 'category' => __('Navigation')],
            ['title' => __('Élèves'), 'url' => route('students.index'), 'icon' => 'fas fa-user-graduate', 'category' => __('Navigation')],
            ['title' => __('Enseignants'), 'url' => route('teachers.index'), 'icon' => 'fas fa-chalkboard-teacher', 'category' => __('Navigation')],
            ['title' => __('Classes'), 'url' => route('classes.index'), 'icon' => 'fas fa-school', 'category' => __('Navigation')],
            ['title' => __('Paramètres'), 'url' => route('schools.settings'), 'icon' => 'fas fa-cog', 'category' => __('Navigation')],
        ];

        if (strlen($this->query) >= 2) {
            $user = auth()->user();
            $usersQuery = User::where('name', 'like', '%' . $this->query . '%')
                ->orWhere('email', 'like', '%' . $this->query . '%');

            if ($user && $user->school_id) {
                $usersQuery->where('school_id', $user->school_id);
            }

            $results = $usersQuery->take(6)->get()->map(function ($u) {
                return [
                    'title' => $u->name,
                    'subtitle' => implode(', ', $u->getRoleNames()->toArray()),
                    'url' => route('students.show', $u->id), // fallback profile link
                    'icon' => 'fas fa-user',
                    'category' => __('Utilisateurs'),
                ];
            })->toArray();

            // Filter nav links by query
            $filteredNav = array_filter($navLinks, function ($link) {
                return stripos($link['title'], $this->query) !== false;
            });

            $results = array_merge($filteredNav, $results);
        }

        return view('livewire.quick-search', [
            'results' => $results,
            'defaultNav' => $navLinks,
        ]);
    }
}
