
<table class="table table-bordered">
                                    <tr>
                                        <td class="narrow-td">
                                            @foreach ($evidences as $evi)
                                                <label style="font-family:Product Sans; cursor: move;" draggable="true" ondragstart="drag(event)" id="{{ $evi->id }}"> {{ $evi->evidence_name }}</label><br>
                                            @endforeach
                                        </td>
                                        <td > 
                                            <!-- <div class="search-icon-container">
                                                <i class="fas fa-search"></i>
                                                <i class="fas fa-times cross-icon"></i>
                                            </div> -->
                                        <span class="maincircle" name="maincircle" id="maincircle"> </span><i class="fas fa-search"></i>
                                        &nbsp; &nbsp;<label style="font-family:Product Sans" id="selectedValue" onclick="showelements()"></label><input type="hidden" name="matrixid" id="matrixid">
                                        <input type="hidden" name="offenceid" id="offenceid">
                                        <br>
                                          <div id="elementsdiv" ></div>

                                        </td>
                                    </tr>
                                </table>
<div class="row"> 
    <div class="col-sm-12">
        <div class="form-group">
            @foreach ($elements as $eleitem)
                <br>
                <?php $elementName = DB::table('tbl_elements_lookup')->where('id', $eleitem->element_id)->value('element_name'); ?>
                {{ $elementName }}
                &nbsp;
                
                <br>
                <label>Evidence:&nbsp;</label>
                <?php $eviName = DB::table('tbl_case_evidences')->where('id', $eleitem->evidence_id)->value('evidence_name'); ?>
                {{ $eviName }}
                <br>
                
                <hr>
            @endforeach
        </div>
    </div>
</div>
