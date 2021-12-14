<?php

namespace App\Repositories;

use App\Http\Requests\UserRequest;
use App\Interfaces\UserInterface;
use App\Models\User;
use App\Traits\ResponseAPI;
use DB;

class UserRepository implements UserInterface
{
    // Use ResponseAPI Trait in this repository
    use ResponseAPI;

    // public function getAllUsers()
    // {
    //     try {
    //         // get all leads
    //         // select b.LeadId, b.CustomerId, b.LeadId from tbl_businesslead b inner join tbl_relocate r on b.CustomerId=r.CustomerId inner join tbl_relocate_channels rc on rc.RelocateId=r.id and b.LeadId=rc.PartnerId where b.IsMigrated=1 group by rc.id limit 3000
    //         $getAllLeads = DB::table('tbl_businesslead')
    //         ->select(['tbl_businesslead.Id as tbl_businessleadId', 'tbl_relocate_channels.Id as channelId', 'tbl_businesslead.LeadId', 'tbl_businesslead.IsMigrated', 'tbl_businesslead.MoovazId'])
    //         ->join('tbl_relocate', 'tbl_relocate.CustomerId', '=', 'tbl_businesslead.CustomerId')
    //         ->join('tbl_relocate_channels', 'tbl_relocate_channels.RelocateId', '=', 'tbl_relocate.id')
    //         ->where('tbl_businesslead.IsMigrated', 1)
    //         ->groupBy('tbl_relocate_channels.Id')
    //         ->take(10)
    //         ->get();
    //         $data = [];
    //         foreach ($getAllLeads as $key => $lead) {
    //             // dd($lead);
    //             $partner = DB::table('tbl_partners')->where('id', $lead->LeadId)->first();
    //             // dd($partner);
    //             // var_dump($partner->ReloVendorId);
    //             // dd($lead->MoovazId);
    //             // var_dump("<br>");
    //             // `Id` bigint NOT NULL AUTO_INCREMENT,
    //             // `RelocateChannelId` bigint DEFAULT NULL,
    //             // `Created` datetime DEFAULT CURRENT_TIMESTAMP,
    //             // `AccountId` char(37) DEFAULT NULL,
    //             // `AccountType` varchar(20) DEFAULT NULL COMMENT 'both/both_agent/both_user/host/host_user/vendor_user/vendor/vendor_agent/vendor_user/customer',
    //             // `SubAccountType` varchar(20) DEFAULT NULL COMMENT 'partner/user/agent/customer',
    //             // `Content` varchar(9999) DEFAULT NULL,
    //             // `ContentType` int DEFAULT NULL COMMENT '1_text/2_image',
    //             // `MessageType` int DEFAULT NULL COMMENT '1_normal/2_quotation',
    //             // `AdditionalData` varchar(500) DEFAULT NULL,
    //             // `OriginalFilename` varchar(100) DEFAULT NULL,
    //             // `ParentFilename` varchar(100) DEFAULT NULL,
    //             // `Note` varchar(500) DEFAULT NULL,
    //             // `IsDisabledFile` int DEFAULT '0',
    //             // `IsMigrated` int DEFAULT '0',
    //             $quotes = DB::table('quotes')->where('consumer_id', $lead->MoovazId)->where('vendor_id', $partner->ReloVendorId)->get();
    //             // dd(count($quotes));
    //             if (!$quotes->isEmpty()) {
    //                 $quotes = (array) $quotes;
    //                 // dd($quotes);
    //                 // $gg = `INSERT INTO 'tbl_relocate_channel_messages' VALUES ('{$lead->channelId}',397,'2021-07-21 04:38:58','9b1f290b-fb59-4f05-8aee-9f18da44bd83','customer','customer','heloo testing\n',1,1,NULL,'','',NULL,0,0)`;
    //                 $gg = strtr("INSERT INTO `pricings` (membership_id, currency, price) VALUES (({membershipQuery}), '{currency}', '{price}');", [
    //                     '{membershipQuery}' => "SELECT id FROM memberships where `uid`",
    //                     '{currency}'        => $lead->channelId
    //                 ]);
    //                 \Log::info('message');
    //                 var_dump($gg);
    //                 array_push($data, $gg);
    //             }
    //         }
    //         dd($data);
    //         dd($getAllLeads);
    //         //for loop
    //         // select * from tbl_partners
    //         //select * from quotes q where q.consumer_id=1115 and vendor id and panda_doc_link is not null and panda_doc_link != ""
    //         //select * from tbl_relocate_channels where CustomerId='ae4a1a5c-9a5e-4fc9-b3e7-af5370035676' and BusinessLeadId='4348e591-1fbb-4245-8e2f-fc28be0aa931'

    //         return $this->success('All Users', $users);
    //     } catch (\Exception $e) {
    //         return $e;
    //     }
    // }

    public function getAllUsers()
    {
        try {
            $dataList = DB::table('tmp_import')->whereIn('id', [7,8])->get();
            // dd($dataList);
            $list  = [];
            $emptyList  = [];
            $count = 0;
            foreach ($dataList as $key => $data) {
                // $busnessLead = DB::table('tbl_businesslead')->where('id', $relo->lead_id)->first();
                $reloChannels = DB::table('tbl_relocate_channels')->where('BusinessLeadId', $data->lead_id)->where('RelocateId', $data->relocate_id)->first();
              
                if (!empty($reloChannels)) {
                    $partner = DB::table('tbl_partners')->where('id', $reloChannels->PartnerId)->first();
                    // dd($reloChannels->Id);
                    $insertData = [
                        'RelocateChannelId' => $reloChannels->Id,
                        'AccountId'         => $reloChannels->PartnerId,
                        'AccountType'       => 'both',
                        'SubAccountType'    => 'partner',
                        'Content'           => 'quotation',
                        'ContentType'       => '1', //1, 3 view quotation 3,2  is signed quotation
                        'MessageType'       => '3',
                        'AdditionalData'    => $data->link,
                        'isMigrated'        => 2,
                    ];
                    $count = $count + 1;
                    array_push($list, $insertData);
                    $ObjectId = DB::table("tbl_relocate_channel_messages")->insertGetId($insertData);
                    DB::table("tbl_businesslead")->where('id', $data->lead_id)->update(['status' => 5]);

                    $notiData = [
                        "Content"       => $partner->Name. " has sent you a new message.",
                        "ContentType"   => 1,
                        "AccountId"     => $partner->Id,
                        'AccountType'       => 'both',
                        'SubAccountType'    => 'partner',
                        'MessageType'    => 3,
                        'PartnerId'    => $partner->Id,
                        'InviteType'    => 1,
                        'CustomerId'    => $reloChannels->CustomerId,
                        'RelocateId'    => $reloChannels->RelocateId,
                        'ObjectId'    => $ObjectId,
                        'Action'    => 2,
                        'IsRead'    => 0,
                        'Title'    => "New Message",
                        'IsMigrated'    => 2,
    
                    ];
                    DB::table("tbl_customer_notification")->insert($notiData);
                    // dd($list);
                } else {
                    array_push($emptyList, $data->lead_id);
                }

              
            }
            return $this->success('All Users', $emptyList);
        } catch (\Exception $e) {
            return $e;
        }
    }

    // public function getAllUsers()
    // {
    //     try {
    //         $users = DB::table('tbl_relocate_channel_messages')
    //         ->select('BusinessLeadId')
    //         ->leftJoin('tbl_relocate_channels', 'tbl_relocate_channels.id', '=', 'tbl_relocate_channel_messages.RelocateChannelId')
    //         ->leftJoin('invoices', 'invoices.invoice_link', '=', 'tbl_relocate_channel_messages.AdditionalData')
    //         ->where('tbl_relocate_channel_messages.IsMigrated', 1)
    //         ->where('tbl_relocate_channel_messages.content', 'invoice')
    //         ->where('invoices.invoice_status', '1')
    //         ->get();
    //         // dd($users);
    //         foreach ($users as $key => $relo) {
    //             $busnessLead = DB::table('tbl_businesslead')->where('id', $relo->BusinessLeadId)->first();
    //             $otherBusinessLeads = DB::table('tbl_businesslead')
    //             ->where('RelocateId', $busnessLead->RelocateId)
    //             ->whereNotIn('Id', [$busnessLead->Id])
    //             ->where('ServiceID', $busnessLead->ServiceID)->get();
    //             // dd($busnessLead);
    //             //   dd($otherBusinessLeads);
    //             foreach ($otherBusinessLeads as $key => $otherBusinessLead) {
    //                 if ($otherBusinessLead->Status == 0) {
    //                     \Log::info('sub abc');
    //                     \Log::info($otherBusinessLead->Id);
    //                     DB::table('tbl_businesslead')->where('Id', $otherBusinessLead->Id)
    //                     ->where('ServiceID', $busnessLead->ServiceID)->update(['Status' => -1]);
    //                 }
    //                 if ($busnessLead->Status == 0) {
    //                     \Log::info('main abc');
    //                     \Log::info($busnessLead->Id);
    //                     DB::table('tbl_businesslead')->where('Id', $busnessLead->Id)
    //                     ->where('ServiceID', $busnessLead->ServiceID)->update(['Status' => 7]); //7 is invoice paid
    //                 }

    //             }
    //             // dd($otherBusinessLead);
    //         }
    //         return $this->success('All Users', $users);
    //     } catch (\Exception $e) {
    //         return $e;
    //     }
    // }

    public function getquote()
    {
        try {
            $users = DB::table('tbl_relocate_channel_messages')
            ->select('BusinessLeadId')
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
                // dd($otherBusinessLeads);
                foreach ($otherBusinessLeads as $key => $otherBusinessLead) {
                    if ($otherBusinessLead->Status == 0) {
                        \Log::info('sub abc');
                        \Log::info($otherBusinessLead->Id);
                        DB::table('tbl_businesslead')->where('Id', $otherBusinessLead->Id)
                        ->where('ServiceID', $busnessLead->ServiceID)->update(['Status' => -1]);
                    }

                    if ($busnessLead->Status == 0) {
                        \Log::info('main abc');
                        \Log::info($busnessLead->Id);
                        DB::table('tbl_businesslead')->where('Id', $busnessLead->Id)
                        ->where('ServiceID', $busnessLead->ServiceID)->update(['Status' => 6]);
                    }
                }
                // dd($otherBusinessLead);
            }
            return $this->success('All Users', $users);
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function getUserById($id)
    {
        try {
            $user = User::find($id);

            // Check the user
            if (!$user) {
                return $this->error("No user with ID $id", 404);
            }

            return $this->success('User Detail', $user);
        } catch (\Exception $e) {
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
            $user = $id ? User::find($id) : new User();

            // Check the user
            if ($id && !$user) {
                return $this->error("No user with ID $id", 404);
            }

            $user->name = $request->name;
            // Remove a whitespace and make to lowercase
            $user->email = preg_replace('/\s+/', '', strtolower($request->email));

            // I dont wanna to update the password,
            // Password must be fill only when creating a new user.
            if (!$id) {
                $user->password = \Hash::make($request->password);
            }

            // Save the user
            $user->save();

            DB::commit();
            return $this->success(
                $id ? 'User updated'
                    : 'User created',
                $user,
                $id ? 200 : 201
            );
        } catch (\Exception $e) {
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
            if (!$user) {
                return $this->error("No user with ID $id", 404);
            }

            // Delete the user
            $user->delete();

            DB::commit();
            return $this->success('User deleted', $user);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->error($e->getMessage(), $e->getCode());
        }
    }
}
