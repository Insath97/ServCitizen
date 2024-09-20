   <!-- Calling Reports Modal -->
   <div class="modal fade" id="calling-form" tabindex="-1" role="dialog" aria-labelledby="callingReportsModalLabel"
       aria-hidden="true">
       <div class="modal-dialog" role="document">
           <div class="modal-content">
               <div class="modal-header">
                   <h5 class="modal-title" id="callingReportsModalLabel">Change Status - Calling Reports</h5>
                   <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                       <span aria-hidden="true">&times;</span>
                   </button>
               </div>
               <div class="modal-body">
                   <form id="callingReportsForm" method="POST">

                       @csrf
                       <input type="hidden" name="token_id" id="token-id">
                       <input type="hidden" name="status_id_one" id="status_id_one">

                       <div class="form-group">
                           <label for="callingReportsStatus">Select Sub-status</label>
                           <select class="form-control" id="callingReportsStatus" name="callingReportsStatus">
                               <option value="report_called">Report Called</option>
                               <option value="inspection_completed">Inspection Completed</option>
                           </select>
                       </div>
                       <div class="form-group">
                           <label for="reportRemarks">Remarks</label>
                           <textarea class="form-control" id="reportRemarks" rows="3"></textarea>
                       </div>

               </div>
               <div class="modal-footer">
                   <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                   <button type="submit" class="btn btn-primary" id="saveCallingReportsStatus">Save changes</button>
               </div>
               </form>
           </div>
       </div>
   </div>
