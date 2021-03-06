<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ComputerConsumable;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ComputerConsumableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|Response
     */
    public function index()
    {
        $computerConsumables = ComputerConsumable::with('category')->latest()->paginate(10);
        return view('admin.computerConsumables.index',['computerConsumables' => $computerConsumables]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View|Response
     */
    public function create()
    {
        $categories = Category::orderBy('name','asc')->get();
        return view('admin.computerConsumables.create',['categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'category_id' => 'required|integer|gt:0|exists:categories,id',
        ]);
        ComputerConsumable::create($data);
        session()->flash('success','ComputerConsumable Has Been Created Successfully');
        return redirect()->route('admin.computerConsumables.index');
    }

    /**
     * Display the specified resource.
     *
     * @param ComputerConsumable $computerConsumable
     * @return Response
     */
    public function show(ComputerConsumable $computerConsumable)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param ComputerConsumable $computerConsumable
     * @return Application|Factory|View|Response
     */
    public function edit(ComputerConsumable $computerConsumable)
    {
        $categories = Category::orderBy('name','asc')->get();
        return view('admin.computerConsumables.edit',compact('computerConsumable','categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param ComputerConsumable $computerConsumable
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, ComputerConsumable $computerConsumable)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'category_id' => 'required|integer|gt:0|exists:categories,id',
        ]);
        $computerConsumable->update($data);
        session()->flash('success','ComputerConsumable Has Been Updated Successfully');
        return redirect()->route('admin.computerConsumables.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ComputerConsumable $computerConsumable
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(ComputerConsumable $computerConsumable)
    {
        $computerConsumable->delete();
        session()->flash('success','ComputerConsumable Has Been Deleted Successfully');
        return redirect()->back();
    }
}
