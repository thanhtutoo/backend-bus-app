<?php

namespace App\Repositories;

use App\Http\Requests\UserRequest;
use App\Interfaces\UserInterface;
use App\Traits\ResponseAPI;
use App\Models\User;
use DB;

class UserRepository implements UserInterface
{
    // Use ResponseAPI Trait in this repository
    use ResponseAPI;

    public function getAllUsers()
    {
        try {
            $users = DB::table('tbl_relocate_channel_messages')
            ->select("BusinessLeadId")
            ->leftJoin('tbl_relocate_channels', 'tbl_relocate_channels.id', '=', 'tbl_relocate_channel_messages.RelocateChannelId')
            ->where('tbl_relocate_channel_messages.IsMigrated', 1)
            ->where('tbl_relocate_channel_messages.content', 'quotation')
            ->where('tbl_relocate_channel_messages.AccountType', 'customer')
            ->get();
            // dd($users);
            foreach ($users as $key => $relo) {
                $busnessLead = DB::table('tbl_businesslead')->where('id', $relo->BusinessLeadId)->first();

                $otherBusinessLeads = DB::table('tbl_businesslead')
                ->where('RelocateId', $busnessLead->RelocateId)
                ->whereNotIn('Id', [$busnessLead->Id])
                ->where('ServiceID', $busnessLead->ServiceID)->get();

                foreach ($otherBusinessLeads as $key => $otherBusinessLead) {
                    DB::table('tbl_businesslead')->where('Id', $otherBusinessLead->Id)
                    ->where('ServiceID', $busnessLead->ServiceID)->update(['Status' => -1]);
                    DB::table('tbl_businesslead')->where('Id', $busnessLead->Id)
                    ->where('ServiceID', $busnessLead->ServiceID)->update(['Status' => 6]);

                }
                // dd($otherBusinessLead);
            }
            return $this->success("All Users", $users);
        } catch(\Exception $e) {
            return $e;
        }
    }

    public function getUserById($id)
    {
        try {
            $user = User::find($id);
            
            // Check the user
            if(!$user) return $this->error("No user with ID $id", 404);

            return $this->success("User Detail", $user);
        } catch(\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    public function requestUser(UserRequest $request, $id = null)
    {
        DB::beginTransaction();
        try {
            // If user exists when we find it
            // Then update the user
            // Else create the new one.
            $user = $id ? User::find($id) : new User;

            // Check the user 
            if($id && !$user) return $this->error("No user with ID $id", 404);

            $user->name = $request->name;
            // Remove a whitespace and make to lowercase
            $user->email = preg_replace('/\s+/', '', strtolower($request->email));
            
            // I dont wanna to update the password, 
            // Password must be fill only when creating a new user.
            if(!$id) $user->password = \Hash::make($request->password);

            // Save the user
            $user->save();

            DB::commit();
            return $this->success(
                $id ? "User updated"
                    : "User created",
                $user, $id ? 200 : 201);
        } catch(\Exception $e) {
            DB::rollBack();
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    public function deleteUser($id)
    {
        DB::beginTransaction();
        try {
            $user = User::find($id);

            // Check the user
            if(!$user) return $this->error("No user with ID $id", 404);

            // Delete the user
            $user->delete();

            DB::commit();
            return $this->success("User deleted", $user);
        } catch(\Exception $e) {
            DB::rollBack();
            return $this->error($e->getMessage(), $e->getCode());
        }
    }
}