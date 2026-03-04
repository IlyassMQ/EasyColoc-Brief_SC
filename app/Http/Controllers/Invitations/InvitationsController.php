<?php

namespace App\Http\Controllers\Invitations;

use App\Http\Requests\StoreInvitationRequest;
use App\Models\Colocation;
use App\Models\Invitation;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\InvitationMail;

class InvitationsController extends Controller
{
    
    public function create(Colocation $colocation)
    {
        $this->isOwner($colocation);

        return view('invitations.create', compact('colocation'));
    }

    
    public function store(StoreInvitationRequest $request)
    {
    $colocation = Colocation::findOrFail($request->colocation_id);

    if (!$colocation->users()
        ->where('user_id', auth()->id())
        ->wherePivot('role_intern', 'owner')
        ->exists()) {
        abort(403, 'Seul le propriétaire peut inviter.');
    }

    $invitation = Invitation::create([
        'colocation_id' => $colocation->id,
        'user_id' => auth()->id(),
        'email' => $request->email,
        'token' => Str::random(32),
        'status' => null,
    ]);

    Mail::to($request->email)
        ->send(new InvitationMail($invitation));

    return redirect()
        ->route('colocations.show', $colocation)
        ->with('success', "Invitation envoyée à {$request->email} !");
    }

   
    public function accept($token)
    {
        $invitation = Invitation::where('token', $token)->firstOrFail();

        
        $invitation->colocation->users()->attach(Auth::id(), [
            'role_intern' => 'member',
            'joined_at' => now(),
        ]);

        $invitation->update(['status' => 'accepted']);

        return redirect()
            ->route('colocations.show', $invitation->colocation)
            ->with('success', "Vous avez rejoint la colocation !");
    }

    
    private function isOwner(Colocation $colocation)
    {
        $membership = $colocation->users()
            ->where('user_id', Auth::id())
            ->first();

        if (!$membership || $membership->pivot->role_intern !== 'owner') {
            abort(403, 'Seul le propriétaire peut effectuer cette action.');
        }
    }
}