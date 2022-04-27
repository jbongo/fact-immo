
<div class="table-responsive" style="overflow-x: inherit !important;">
    <table  id="example2" class=" table student-data-table  m-t-20 "  style="width:100%">
        <thead>
            <tr  style="background-color: #2a596d;">
                <th style=" color:#fff">@lang('Nom')</th>
                <th style=" color:#fff">@lang('Type')</th>
                <th style=" color:#fff">@lang('Téléphone')</th>
                <th style=" color:#fff">@lang('Site web')</th>
                <th style=" color:#fff">@lang('Email')</th>
                <th style=" color:#fff">@lang('Login')</th>
                <th style=" color:#fff">@lang('Mot de passe')</th>
                <th style=" color:#fff">@lang('Action')</th>
               
            </tr>
        </thead>
        <tbody>
        
        @foreach ($fournisseurs_autres as $fournisseur)
            <tr>

                <td style="color: #e05555; text-decoration: underline;">
                <strong>{{$fournisseur->nom}}</strong> 
                </td>
                <td style="color: #32ade1;">
                     {{$fournisseur->type}}  
                </td>
                <td style="color: #32ade1;">
                    {{$fournisseur->telephone}}
                </td>
                <td style="color: #32ade1;">
                    {{$fournisseur->site_web}}
                </td>
                <td style="color: #32ade1;">
                    {{$fournisseur->email}}
                </td>
                <td style="color: #32ade1;">
                    {{$fournisseur->login}}
                </td>
                <td style="color: #32ade1;">
                    {{$fournisseur->password}}
                </td>

                <td>
                    <span><a href="{{route('fournisseur.show',Crypt::encrypt($fournisseur->id))}}" data-toggle="tooltip" title="@lang('Afficher ') {{ $fournisseur->nom }}"><i class="large material-icons color-success">remove_red_eye</i></a></span>
                    {{-- <span><a class="btn btn-default" href="{{route('article.index', Crypt::encrypt($fournisseur->id))}}" data-toggle="tooltip" title="@lang('Voir les annonces ') "><i class="large material-icons color-warning">remove_red_eye</i>Articles</a></span> --}}
                    <span><a href="{{route('fournisseur.edit',Crypt::encrypt($fournisseur->id))}}" data-toggle="tooltip" title="@lang('Modifier ') {{ $fournisseur->nom }}"><i class="large material-icons color-warning">edit</i></a></span>
                <span><a  href="{{route('fournisseur.edit',$fournisseur->id)}}" class="delete" data-toggle="tooltip" title="@lang('Archiver ') {{ $fournisseur->nom }}"><i class="large material-icons color-danger">delete</i> </a></span>
                </td>
            </tr>
    @endforeach
      </tbody>
    </table>
</div>

