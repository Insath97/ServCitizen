   <!-- Document Verification Modal -->
   <div class="modal fade" id="verification-form" tabindex="-1" role="dialog" aria-labelledby="verificationModalLabel"
       aria-hidden="true">
       <div class="modal-dialog" role="document">
           <div class="modal-content">
               <div class="modal-header">
                   <h5 class="modal-title" id="verificationModalLabel">Change Status - Document Verification</h5>
                   <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                       <span aria-hidden="true">&times;</span>
                   </button>
               </div>
               <div class="modal-body">
                   <form id="documentVerificationForm" method="POST">
                       @csrf

                       <input type="hidden" name="token_id" id="token-id">
                       <input type="hidden" name="status_id_one" id="status_id_one">

                       <div class="form-group">
                           <label for="documentVerificationStatus">Select Option</label>
                           <select class="form-control" id="documentVerificationStatus"
                               name="documentVerificationStatus">
                               <option value="verified">Verified</option>
                               <option value="returned">Returned</option>
                               <option value="resubmitted">Resubmitted</option>
                           </select>
                       </div>

                       <div class="form-group">
                           <label for="remarks">Remarks</label>
                           <textarea class="form-control" id="remarks" rows="3"></textarea>
                       </div>
               </div>
               <div class="modal-footer">
                   <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                   <button type="submit" class="btn btn-primary" id="saveVerificationStatus">Save changes</button>
               </div>
               </form>
           </div>
       </div>
   </div>
