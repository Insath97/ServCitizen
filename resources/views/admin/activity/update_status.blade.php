{{-- update status model --}}
<div class="modal fade" id="open-form" tabindex="-1" role="dialog" aria-labelledby="updateStatusModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateStatusModalLabel">Update Ticket Status</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="updateStatusForm" method="POST">

                    @csrf

                    <input type="hidden" id="modal-token-id" name="token_id">
                    <input type="hidden" name="status_id_one" id="status_id_one">
                    <input type="hidden" name="status_name" id="status_name">

                    <div class="form-group">
                        <label for="modal-ticket-status">Ticket Status</label>
                        <select class="form-control" id="modal-ticket-status" name="ticket_status" required>
                            @foreach ($statuses as $item)
                                <option value="{{ $item->id }}" data-color="{{ $item->status_color }}">
                                    {{ $item->status_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="modal-status-feedback">Status Feedback</label>
                        <textarea class="form-control" id="modal-status-feedback" name="status_feedback" rows="3"
                            placeholder="Enter feedback or comments"></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Update Status</button>
                </form>
            </div>
        </div>
    </div>
</div>
