<div class="modal fade" id="{{ $settings['id'] }}" tabindex='-1'>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">{{ $settings['title'] }}</h4>
            </div>
            <div class="modal-body">
                <p>{{ $settings['content'] }}</p>
            </div>
            <div class="modal-footer" style="text-align: center">
                @foreach($settings['buttons'] as $button)
                    @if(\App\BaseWidget\Validator::checkIsButtonTag($button))
                        {!! \App\BaseWidget\Form::button($button['text'], $button['attributes']) !!}
                    @else
                        {!! \App\BaseWidget\Form::a($button['text'], $button['href'], $button['attributes']) !!}
                    @endif
                @endforeach
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->