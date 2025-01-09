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
