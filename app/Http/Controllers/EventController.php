<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Models\Event;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{

    public function __invoke()
    {
       return view('index');
    }
    public function index(): JsonResponse
    {
//       dd(auth()->user());
       $events = Auth::user()->events()->get();
        return response()->json($events);
    }

    public function store(Request $request): JsonResponse
    {
        // Валідація даних

        $validated = $request->validate([
            'cad_title' => 'required|string|max:255',
            'cad_color' => 'nullable|string|max:50',
            'cad_start' => 'required|date',
            'cad_end' => 'nullable|date|after_or_equal:cad_start',
            'cad_obs' => 'nullable|string',
        ]);

        // Створення події
        $event = Event::create([
            'title' => $validated['cad_title'],
            'user_id' => Auth::id(),
            'color' => $validated['cad_color'] ?? null,
            'start' => $validated['cad_start'],
            'end' => $validated['cad_end'] ?? null,
            'obs' => $validated['cad_obs'] ?? null,
        ]);

        // JSON-відповідь
        return response()->json([
            'status' => true,
            'msg' => 'Подія успішно зареєстрована!',
            'id' => $event->id,
            'title' => $event->title,
            'color' => $event->color,
            'start' => $event->start,
            'end' => $event->end,
            'obs' => $event->obs,
        ]);
    }
    public function update(Request $request, $id): JsonResponse
    {
        // Валідація вхідних даних
        $validated = $request->validate([
            'edit_title' => 'required|string|max:255',
            'edit_color' => 'nullable|string|max:50',
            'edit_start' => 'required|date',
            'edit_end' => 'nullable|date|after_or_equal:edit_start',
            'edit_obs' => 'nullable|string',
        ]);

        // Знаходимо подію або викидаємо 404
        $event = Event::findOrFail($id);

        // Оновлюємо поля
        $event->title = $validated['edit_title'];
        $event->color = $validated['edit_color'] ?? null;
        $event->start = $validated['edit_start'];
        $event->end = $validated['edit_end'] ?? null;
        $event->obs = $validated['edit_obs'] ?? null;

        // Зберігаємо зміни
        $event->save();

        // Повертаємо JSON відповідь
        return response()->json([
            'status' => true,
            'msg' => 'Подію успішно оновленно!',
            'id' => $event->id,
            'title' => $event->title,
            'color' => $event->color,
            'start' => $event->start,
            'end' => $event->end,
            'obs' => $event->obs,
        ]);
    }
    public function destroy($id)
    {
        $event = Event::find($id);

        if (!$event) {
            return response()->json([
                'status' => false,
                'msg' => 'Помилка: Подія не знайдена!'
            ], 404);
        }

        if ($event->delete()) {
            return response()->json([
                'status' => true,
                'msg' => 'Подію успішно видалено!'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'msg' => 'Помилка: Подія не видалена!'
            ], 500);
        }
    }

}
