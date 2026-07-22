<div class="card">
   <div class="card-body">
      <div class="profile-image-wrapper flex justify-center mt-6 mb-8" >
         <img src="{{asset($user->profile_photo_url)}}" alt="user photo" class="rounded-full profile-image border-4 border-white dark:border-slate-800 shadow-xl ring-4 ring-slate-100 dark:ring-slate-700/50 object-cover" style="width: 175px;height: 175px;"/>  
      </div>
      <h2 class="text-center text-3xl font-bold tracking-tight text-slate-800 dark:text-slate-100 mb-6">{{$user->name}}</h2>
      <div class="w-full md:w-8/12 m-auto">
         <h4 class="text-left text-xl font-semibold text-slate-700 dark:text-slate-300 mb-4">Personal information</h4>
         <x-show-table :body="[
               ['First Name' , $user->first_name],
               ['Last Name' , $user->last_name],
               ['Other Name' , $user->other_names],
               ['Email' , $user->email],
               ['Gender' , $user->gender],
               ['Birthday' , $user->birthday],
               ['nationality' , $user->nationality],
               ['state' , $user->state],
               ['City' , $user->city],
               ['Address' , $user->address],
               ['Religion' , $user->religion],
               ['Blood Group' , $user->blood_group],
               ['Phone' , $user->phone],

         ]"/>
      </div>
   </div>
</div>
