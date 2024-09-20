 <!-- Edit Divisional Secretariat Modal -->
 <div class="modal fade" tabindex="-1" role="dialog" id="editDivisionModal">
     <div class="modal-dialog modal-lg" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title">Edit Divisional Secretariat</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>
             <div class="modal-body">
                 <form action="" method="post" id="editDivisionForm">
                     @csrf
                     @method('PUT')

                     <!-- Province and District -->
                     <div class="form-row">
                         <div class="form-group col-md-6">
                             <label>Province Name</label>
                             <select name="province_update" id="province_id_update"
                                 class="form-control @error('province_update') is-invalid @enderror">
                                 <option value="">Select Province</option>
                                 @foreach ($province as $item)
                                     <option value="{{ $item->id }}">{{ $item->province }}</option>
                                 @endforeach
                             </select>
                             @error('province_update')
                                 <div class="invalid-feedback">{{ $message }}</div>
                             @enderror
                         </div>

                         <div class="form-group col-md-6">
                             <label>District Name</label>
                             <select name="district_update" id="district_id_update"
                                 class="form-control @error('district_update') is-invalid @enderror">
                                 <option value="">Select District</option>
                                 @foreach ($districts as $item)
                                     <option value="{{ $item->id }}">{{ $item->district }}</option>
                                 @endforeach
                             </select>
                             @error('district_update')
                                 <div class="invalid-feedback">{{ $message }}</div>
                             @enderror
                         </div>
                     </div>

                     <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="province" class="col-form-label font-weight-bold">Divisional Secretariat
                                Code</label>
                            <input type="number" class="form-control @error('ds_code_update') is-invalid @enderror"
                                id="ds_code_update" name="ds_code_update" placeholder="Enter Divisional Secretariat code" required>
                            @error('ds_code_update')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                     <!-- Divisional Secretariat and Address -->
                     <div class="form-row">
                         <div class="form-group col-md-6">
                             <label>Divisional Secretariat</label>
                             <input type="text" name="ds_name_update"
                                 class="form-control @error('ds_name_update') is-invalid @enderror"
                                 placeholder="Enter Divisional Secretariat Name" required>
                             @error('ds_name_update')
                                 <div class="invalid-feedback">{{ $message }}</div>
                             @enderror
                         </div>

                         <div class="form-group col-md-6">
                             <label>Address</label>
                             <input type="text" name="address_update"
                                 class="form-control @error('address_update') is-invalid @enderror"
                                 placeholder="Enter Address">
                             @error('address_update')
                                 <div class="invalid-feedback">{{ $message }}</div>
                             @enderror
                         </div>
                     </div>

                     <!-- Telephone, Fax, Email, and DS Officer -->
                     <div class="form-row">
                         <div class="form-group col-md-6">
                             <label>Telephone</label>
                             <input type="text" name="telephone_update"
                                 class="form-control @error('telephone_update') is-invalid @enderror"
                                 placeholder="Enter Telephone Number">
                             @error('telephone_update')
                                 <div class="invalid-feedback">{{ $message }}</div>
                             @enderror
                         </div>

                         <div class="form-group col-md-6">
                             <label>Fax</label>
                             <input type="text" name="fax_update"
                                 class="form-control @error('fax_update') is-invalid @enderror" placeholder="Enter Fax Number">
                             @error('fax_update')
                                 <div class="invalid-feedback">{{ $message }}</div>
                             @enderror
                         </div>
                     </div>

                     <div class="form-row">
                         <div class="form-group col-md-6">
                             <label>Email</label>
                             <input type="email" name="email_update"
                                 class="form-control @error('email_update') is-invalid @enderror"
                                 placeholder="Enter Email Address">
                             @error('email_update')
                                 <div class="invalid-feedback">{{ $message }}</div>
                             @enderror
                         </div>

                         <div class="form-group col-md-6">
                             <label>DS Officer</label>
                             <input type="text" name="ds_officer_update"
                                 class="form-control @error('ds_officer_update') is-invalid @enderror"
                                 placeholder="Enter DS Officer Name">
                             @error('ds_officer_update')
                                 <div class="invalid-feedback">{{ $message }}</div>
                             @enderror
                         </div>
                     </div>

             </div>
             <div class="modal-footer">
                 <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                 <button type="submit" class="btn btn-primary">Save</button>
             </div>
             </form>
         </div>
     </div>
 </div>
