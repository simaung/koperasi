    <div class="row">
        <div class="col-12">
            <?php if ($petugas->access_system == '0') { ?>
                <div class="col-12">
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Level : </label>
                        <select name="level" class="form-control" id="level">
                            <option value="operator">Operator</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                </div>
            <?php } ?>
            <div class="col-12">
                <?php if ($petugas->access_system == '0') { ?>
                    <button class="btn btn-primary btn-lg btn-block" onclick="prosesUpdateAccess(<?php echo $petugas->id; ?>,'1')">Berikan akses</button>
                <?php } else { ?>
                    <button class="btn btn-danger btn-lg btn-block" onclick="prosesUpdateAccess(<?php echo $petugas->id; ?>,'0')">Cabut akses</button>
                <?php } ?>
            </div>
            <!-- <div class="col-12">
                <div class="form-group">
                    <label for="message-text" class="col-form-label mt-4">Access System : </label>
                    <div class="form-group clearfix mt-2">
                        <div class="icheck-primary d-inline">
                            <input type="radio" id="radioPrimary1" name="access_system" value="0" <?php echo ($petugas->access_system == '0') ? 'checked' : ''; ?>>
                            <label for="radioPrimary1">
                                Tidak
                            </label>
                        </div>
                        <div class="icheck-primary d-inline">
                            <input type="radio" id="radioPrimary2" name="access_system" value="1" <?php echo ($petugas->access_system == '1') ? 'checked' : ''; ?>>
                            <label for="radioPrimary2">
                                Ya
                            </label>
                        </div>
                    </div>
                </div>
            </div> -->
        </div>
    </div>
    <!-- <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div> -->