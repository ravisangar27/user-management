<div class="row">
    <div class="col-md-12"> 
        <table class="table table-striped table-header-rotated">
            <thead> 
                <tr> 
                    <th></th>
                    @foreach($permissionActions as $action)
                    <th><div class="rotate-45"><span>{!! $action['display_name'] !!}</span></div></th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
            
                @foreach($permissionModel as $model)
                <tr>
                    <td>{!! $model['display_name'] !!}</td>
                    @foreach($permissionActions as $action)
                    <td>
                        @if($permission->where('name', $model['name'].'-'.$action['name'])->count())
                            <a href="{!! route('permission.show', [$permission->where('name', $model['name'].'-'.$action['name'])->first()->id]) !!}" class='btn btn-primary'>show</a> 
                          
                        @endif
                    </td> 

                    @endforeach
                </tr>
                @endforeach 
            
            </tbody> 
        
        </table>  
    </div>
</div>