<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\ChatRoom;
use App\Models\ChatMessage;

use App\Events\NewChatMessage;

use Carbon\Carbon; 
class chatController extends Controller
{
    public function rooms (Request $request){
        return Chatroom::all() ;
    }

    public function messages (Request $request, $roomId) {
         $chatMessages = ChatMessage::where('chat_room_id', $roomId)
                        ->with('user')
                        ->orderBy('created_at', 'DESC')
                        ->get();
         $userId = Auth::id();

        foreach ($chatMessages as $message) {
            $hour = Carbon::parse($message->created_at)->format('H:i');
            $message->{"hour"} = $hour;
            
        }

        
        
         
         
         
         return [$chatMessages, $userId];
    } 
    public function newMessage (Request $request, $roomId) {
        $newMessage = new ChatMessage;
        $newMessage->user_id = Auth::id();
        $newMessage->chat_room_id = $roomId;
        $newMessage->message = $request -> message;
        $newMessage->save();

        broadcast(new NewChatMessage($newMessage)) -> toOthers();

        return $newMessage;

    } 


}
