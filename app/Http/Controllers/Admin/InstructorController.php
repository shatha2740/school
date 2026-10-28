<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Instructor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class InstructorController extends Controller
{

    public function index(): View
    {
        $instructors = Instructor::with('user')
            ->withCount('courses')
            ->orderBy('name')
            ->paginate(10);

        return view('instructors.index', compact('instructors'));
    }

    public function create(): View
    {
        $instructor = new Instructor();
        $users = $this->availableUsers();

        return view('instructors.create', compact('instructor', 'users'));
    }


    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:191',

            'user_id' => 'nullable|exists:users,id|unique:instructors,user_id',

            'account_name' => 'required_without:user_id|nullable|string|max:191',
            'account_email' => 'required_without:user_id|nullable|email|max:191|unique:users,email',
            'account_password' => 'required_without:user_id|nullable|string|min:8|confirmed',

            'specialization' => 'nullable|string|max:191',
            'bio' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->filled('user_id')) {
            $user = User::findOrFail($data['user_id']);
        } else {
            $user = User::create([
                'name' => $data['account_name'],
                'email' => $data['account_email'],
                'password' => Hash::make($data['account_password']),
                    'locale' => app()->getLocale(),
            ]);
        }

        $user->assignRole('instructor');


        $image = null;

        if ($request->hasFile('image')) {
            $image = $request->file('image')
                ->store('uploads/instructors');
        }


        $instructor = Instructor::create([
            'user_id' => $user->id,
            'name' => $data['name'],
            'specialization' => $data['specialization'] ?? null,
            'bio' => $data['bio'] ?? null,
            'image' => $image,
                'locale' => app()->getLocale(),
        ]);

        return redirect()
            ->route('instructors.show', $instructor)
            ->with('success', 'تمت إضافة المدرب بنجاح.');
    }


    public function show(Instructor $instructor): View
    {
        $instructor->load(['user', 'courses']);

        return view('instructors.show', compact('instructor'));
    }

    public function edit(Instructor $instructor): View
    {
        $users = $this->availableUsers();

        return view('instructors.edit', compact('instructor', 'users'));
    }

    public function update(Request $request, Instructor $instructor): RedirectResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:191',
            'specialization' => 'nullable|string|max:191',
            'bio' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $newImage = $request->file('image')
                ->store('uploads/instructors');

            if ($instructor->image) {
                Storage::disk('public')->delete($instructor->image);
            }

            $data['image'] = $newImage;
        }

        $instructor->update($data);

        return redirect()
            ->route('instructors.show', $instructor)
            ->with('success', 'تم تحديث بيانات المدرب بنجاح.');
    }


    public function destroy(Instructor $instructor): RedirectResponse
    {

        if ($instructor->courses()->exists()) {
            return back()->withErrors([
                'instructor' => 'لا يمكن حذف مدرب مرتبط بكورسات. أعيدي إسناد الكورسات أولًا.',
            ]);
        }


        if ($instructor->image) {
            Storage::disk('public')->delete($instructor->image);
        }
        $instructor->user?->removeRole('instructor');


        $instructor->delete();

        return redirect()
            ->route('instructors.index')
            ->with('success', 'تم حذف المدرب بنجاح.');
    }


    private function availableUsers()
    {
        return User::whereDoesntHave('instructor')
            ->whereDoesntHave('roles', function ($query) {
                $query->where('name', 'admin');
            })
            ->orderBy('name')
            ->get();
    }
}
