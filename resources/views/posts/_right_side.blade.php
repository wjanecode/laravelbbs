<div class="card" >

     <div class="card-header">
       <h3>活跃用户</h3>
     </div>


    <div class="card-body">
            @foreach($active_users as $active_user)
            <li class="media">
                <div class="media-left">
                    <a href="{{ route('users.show',[$active_user->id]) }}">
                        <img class="media-object" src="{{ asset($active_user->avatar) }}" alt=""  style="width: 20px;height: 20px">
                    </a>
                </div>
                <div class="media-body">
                    <a href="{{ route('users.show',[$active_user->id]) }}">{{ $active_user->name }}</a>
                </div>
            </li>
            @endforeach

    </div>
</div>



<div class="card">
  <div class="card-body">
    <h4 class="card-title">Special title treatment</h4>
    <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
    <a href="#" class="btn btn-primary">Go somewhere</a>
  </div>
</div>


<div class="card">
  <div class="card-body">
    <h4 class="card-title">Special title treatment</h4>
    <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
    <a href="#" class="btn btn-primary">Go somewhere</a>
  </div>
</div>

