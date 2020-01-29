<div class="modal text-dark fade" tabindex="-1" role="dialog" id="{{ $id }}">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">{{ $title }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>{{ $slot }}</p>
      </div>
      <div class="modal-footer">
        <button class="btn btn-link" data-dismiss="modal">Annuleer</button>
        {{ $footer }}
      </div>
    </div>
  </div>
</div>