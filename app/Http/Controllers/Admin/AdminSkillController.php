<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use App\Models\SkillCategory;
use Illuminate\Http\Request;

class AdminSkillController extends Controller
{
    public function index()
    {
        $categories = SkillCategory::with('skills')->orderBy('sort_order')->get();
        return view('admin.skills.index', ['categories' => $categories]);
    }

    // ── Categories ─────────────────────────────────────────────
    public function createCategory()
    {
        return view('admin.skills.create-category', []);
    }

    public function storeCategory(Request $request)
    {
        $validated = $request->validate([
            'name'       => ['required', 'string', 'max:100'],
            'icon'       => ['nullable', 'string', 'max:50'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        SkillCategory::create($validated);
        return redirect()->route('admin.skills.index')->with('success', 'Category added.');
    }

    public function editCategory(SkillCategory $category)
    {
        return view('admin.skills.edit-category', ['category' => $category]);
    }

    public function updateCategory(Request $request, SkillCategory $category)
    {
        $validated = $request->validate([
            'name'       => ['required', 'string', 'max:100'],
            'icon'       => ['nullable', 'string', 'max:50'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $category->update($validated);
        return redirect()->route('admin.skills.index')->with('success', 'Category updated.');
    }

    public function destroyCategory(SkillCategory $category)
    {
        $category->delete();
        return redirect()->route('admin.skills.index')->with('success', 'Category deleted.');
    }

    // ── Skills ─────────────────────────────────────────────────
    public function create()
    {
        $categories = SkillCategory::orderBy('sort_order')->get();
        return view('admin.skills.create', ['categories' => $categories]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'skill_category_id' => ['required', 'exists:skill_categories,id'],
            'name'              => ['required', 'string', 'max:100'],
            'level'             => ['required', 'in:primary,secondary'],
            'sort_order'        => ['nullable', 'integer', 'min:0'],
        ]);

        Skill::create($validated);
        return redirect()->route('admin.skills.index')->with('success', 'Skill added.');
    }

    public function edit(Skill $skill)
    {
        $categories = SkillCategory::orderBy('sort_order')->get();
        return view('admin.skills.edit', [
            'skill'      => $skill,
            'categories' => $categories,
        ]);
    }

    public function update(Request $request, Skill $skill)
    {
        $validated = $request->validate([
            'skill_category_id' => ['required', 'exists:skill_categories,id'],
            'name'              => ['required', 'string', 'max:100'],
            'level'             => ['required', 'in:primary,secondary'],
            'sort_order'        => ['nullable', 'integer', 'min:0'],
        ]);

        $skill->update($validated);
        return redirect()->route('admin.skills.index')->with('success', 'Skill updated.');
    }

    public function destroy(Skill $skill)
    {
        $skill->delete();
        return redirect()->route('admin.skills.index')->with('success', 'Skill deleted.');
    }
}