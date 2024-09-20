  <!-- Final Decision Modal -->
  <div class="modal fade" id="final-decision-form" tabindex="-1" role="dialog" aria-labelledby="finalDecisionModalLabel"
      aria-hidden="true">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="finalDecisionModalLabel">Change Status - Final Decision</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                  <form id="finalDecisionForm" method="POST">

                      @csrf
                      <input type="hidden" name="token_id" id="token-id">
                      <input type="hidden" name="status_id_one" id="status_id_one">

                      <div class="form-group">
                          <label for="finalDecisionStatus">Select Sub-status</label>
                          <select class="form-control" id="finalDecisionStatus" name="finalDecisionStatus">
                              <option value="approved">Approved</option>
                              <option value="clarification">Clarification</option>
                              <option value="escalated">Escalated</option>
                              <option value="rejected">Rejected</option>
                          </select>
                      </div>
                      <div class="form-group">
                          <label for="finalDecisionRemarks">Remarks</label>
                          <textarea class="form-control" id="finalDecisionRemarks" rows="3"></textarea>
                      </div>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary" id="saveFinalDecisionStatus">Save changes</button>
              </div>
              </form>
          </div>
      </div>
  </div>
