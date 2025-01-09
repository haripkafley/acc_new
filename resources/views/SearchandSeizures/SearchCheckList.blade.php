@extends('layouts.admin')

@section('content')

<style>
    .coi_show {
        display: none;
    }

    .coi_hide {
        display: none;
    }
</style>
<br>

<!-- MAIN TBALE -->
<section id="table1s" class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card" id="printSearchCheckList">
                    <div class="card-header">
                        <h2 class="card-title text-info"><b>Search CheckList</b></h2>
                    </div>
                    <div class="card-body">
                        <br>
                        
                        <table style="border: 1px solid;">
                            <col >
                            <colgroup span="2"></colgroup>
                            <tr class="bg-info text-center" >
                                <th rowspan="2" class="align-middle" style="border: 1px solid;">Sl. No</th>
                                <th rowspan="2" class="align-middle" style="border: 1px solid;">Particulars</th>
                                <th rowspan="2" class="align-middle" style="border: 1px solid;">ACAB 2011 Provisions</th>
                                <th colspan="2" scope="colgroup" style="border: 1px solid;">Select As Appropriate</th>
                            </tr>
                            <tr class="bg-info text-center">
                                <th scope="col" style="border: 1px solid;">Yes</th>
                                <th scope="col" style="border: 1px solid;">No</th>
                            </tr>
                            {{-- Sub Header 1 --}}
                            <tr class="bg-secondary">
                                <th class="text-center" style="border: 1px solid;">1</th>
                                <th id="par" colspan="4" scope="colgroup" style="border: 1px solid;"><b>Search Warrant</b></th>
                            </tr>
                            {{-- Sub Header 1 Data --}}
                            <tr>
                                <td class="text-center" style="border: 1px solid;">A</td>
                                <td style="border: 1px solid;">Probable cause for search</td>
                                <td class="text-center" style="border: 1px solid;">Sections 95</td>
                                <td class="text-center" style="border: 1px solid;">
                                    <input class="form-check-input" type="checkbox" name="flexRadioDefault" id="flexRadioDefaults1a">
                                </td>
                                <td class="text-center" style="border: 1px solid;">
                                    <input class="form-check-input" type="checkbox" name="flexRadioDefault" id="flexRadioDefaults1a">
                                </td>
                            </tr>
                            {{-- Sub Header 1 Data --}}
                            <tr>
                                <td class="text-center" style="border: 1px solid;">B</td>
                                <td style="border: 1px solid;">Court Warrant for the arrest If ’NO’ go to Sl. No. 1.c</td>
                                <td class="text-center" style="border: 1px solid;">Sections 95, 96 & 97</td>
                                <td class="text-center" style="border: 1px solid;">
                                    <input class="form-check-input" type="checkbox" name="flexRadioDefault" id="flexRadioDefault1">
                                </td>
                                <td class="text-center" style="border: 1px solid;">
                                    <input class="form-check-input" type="checkbox" name="flexRadioDefault" id="flexRadioDefault1">
                                </td>
                            </tr>
                            {{-- Sub Header 1 Data --}}
                            <tr>
                                <td class="text-center" style="border: 1px solid;">C</td>
                                <td style="border: 1px solid;">Search Warrant from the Commission</td>
                                <td class="text-center" style="border: 1px solid;">Sections 98</td>
                                <td class="text-center" style="border: 1px solid;">
                                    <input class="form-check-input" type="checkbox" name="flexRadioDefault" id="flexRadioDefault1">
                                </td>
                                <td class="text-center" style="border: 1px solid;">
                                    <input class="form-check-input" type="checkbox" name="flexRadioDefault" id="flexRadioDefault1">
                                </td>
                            </tr>
                    
                            {{-- Sub Header 2 --}}
                            <tr class="bg-secondary">
                                <th class="text-center" style="border: 1px solid;">2</th>
                                <th id="par" colspan="4" scope="colgroup" style="border: 1px solid;"><b>Pre-Operation</b></th>
                            </tr>
                            {{-- Sub Header 2 Data --}}
                            <tr>
                                <td class="text-center" style="border: 1px solid;">A</td>
                                <td style="border: 1px solid;">Are two independent witnesses from local government / municipal / community in station?</td>
                                <td class="text-center" style="border: 1px solid;"></td>
                                <td class="text-center" style="border: 1px solid;">
                                    <input class="form-check-input" type="checkbox" name="flexRadioDefault" id="flexRadioDefault1">
                                </td>
                                <td class="text-center" style="border: 1px solid;">
                                    <input class="form-check-input" type="checkbox" name="flexRadioDefault" id="flexRadioDefault1">
                                </td>
                            </tr>
                            {{-- Sub Header 2 Data --}}
                            <tr>
                                <td class="text-center" style="border: 1px solid;">B</td>
                                <td style="border: 1px solid;">Is assistance from other law enforcement agencies required?</td>
                                <td class="text-center" style="border: 1px solid;"></td>
                                <td class="text-center" style="border: 1px solid;">
                                    <input class="form-check-input" type="checkbox" name="flexRadioDefault" id="flexRadioDefault1">
                                </td>
                                <td class="text-center" style="border: 1px solid;">
                                    <input class="form-check-input" type="checkbox" name="flexRadioDefault" id="flexRadioDefault1">
                                </td>
                            </tr>
                            {{-- Sub Header 2 Data --}}
                            <tr>
                                <td class="text-center" style="border: 1px solid;">C</td>
                                <td style="border: 1px solid;">Is gender requirement for search (same gender search) fulfilled?</td>
                                <td class="text-center" style="border: 1px solid;"></td>
                                <td class="text-center" style="border: 1px solid;">
                                    <input class="form-check-input" type="checkbox" name="flexRadioDefault" id="flexRadioDefault1">
                                </td>
                                <td class="text-center" style="border: 1px solid;">
                                    <input class="form-check-input" type="checkbox" name="flexRadioDefault" id="flexRadioDefault1">
                                </td>
                            </tr>
                            {{-- Sub Header 2 Data --}}
                            <tr>
                                <td class="text-center" style="border: 1px solid;">D</td>
                                <td style="border: 1px solid;">Has the Commander of the operation been appointed?</td>
                                <td class="text-center" style="border: 1px solid;"></td>
                                <td class="text-center" style="border: 1px solid;">
                                    <input class="form-check-input" type="checkbox" name="flexRadioDefault" id="flexRadioDefault1">
                                </td>
                                <td class="text-center" style="border: 1px solid;">
                                    <input class="form-check-input" type="checkbox" name="flexRadioDefault" id="flexRadioDefault1">
                                </td>
                            </tr>
                            {{-- Sub Header 2 Data --}}
                            <tr>
                                <td class="text-center" style="border: 1px solid;">E</td>
                                <td style="border: 1px solid;">Has every member of the team understood what to do collectively and their individual tasks?</td>
                                <td class="text-center" style="border: 1px solid;"></td>
                                <td class="text-center" style="border: 1px solid;">
                                    <input class="form-check-input" type="checkbox" name="flexRadioDefault" id="flexRadioDefault1">
                                </td>
                                <td class="text-center" style="border: 1px solid;">
                                    <input class="form-check-input" type="checkbox" name="flexRadioDefault" id="flexRadioDefault1">
                                </td>
                            </tr>
                            {{-- Sub Header 2 Data --}}
                            <tr>
                                <td class="text-center" style="border: 1px solid;">F</td>
                                <td style="border: 1px solid;">Is the reconnaissance information adequate and reliable?</td>
                                <td class="text-center" style="border: 1px solid;"></td>
                                <td class="text-center" style="border: 1px solid;">
                                    <input class="form-check-input" type="checkbox" name="flexRadioDefault" id="flexRadioDefault1">
                                </td>
                                <td class="text-center" style="border: 1px solid;">
                                    <input class="form-check-input" type="checkbox" name="flexRadioDefault" id="flexRadioDefault1">
                                </td>
                            </tr>
                            {{-- Sub Header 2 Data --}}
                            <tr>
                                <td class="text-center" style="border: 1px solid;">G</td>
                                <td style="border: 1px solid;">Is address of the premises correct?</td>
                                <td class="text-center" style="border: 1px solid;"></td>
                                <td class="text-center" style="border: 1px solid;">
                                    <input class="form-check-input" type="checkbox" name="flexRadioDefault" id="flexRadioDefault1">
                                </td>
                                <td class="text-center" style="border: 1px solid;">
                                    <input class="form-check-input" type="checkbox" name="flexRadioDefault" id="flexRadioDefault1">
                                </td>
                            </tr>
                            {{-- Sub Header 2 Data --}}
                            <tr>
                                <td class="text-center" style="border: 1px solid;">H</td>
                                <td style="border: 1px solid;">Is the probable extent and the area of search known?</td>
                                <td class="text-center" style="border: 1px solid;"></td>
                                <td class="text-center" style="border: 1px solid;">
                                    <input class="form-check-input" type="checkbox" name="flexRadioDefault" id="flexRadioDefault1">
                                </td>
                                <td class="text-center" style="border: 1px solid;">
                                    <input class="form-check-input" type="checkbox" name="flexRadioDefault" id="flexRadioDefault1">
                                </td>
                            </tr>
                            {{-- Sub Header 2 Data --}}
                            <tr>
                                <td class="text-center" style="border: 1px solid;">I</td>
                                <td style="border: 1px solid;">Is the accessibility to the premises and the parking identified?</td>
                                <td class="text-center" style="border: 1px solid;"></td>
                                <td class="text-center" style="border: 1px solid;">
                                    <input class="form-check-input" type="checkbox" name="flexRadioDefault" id="flexRadioDefault1">
                                </td>
                                <td class="text-center" style="border: 1px solid;">
                                    <input class="form-check-input" type="checkbox" name="flexRadioDefault" id="flexRadioDefault1">
                                </td>
                            </tr>
                            {{-- Sub Header 2 Data --}}
                            <tr>
                                <td class="text-center" style="border: 1px solid;">J</td>
                                <td style="border: 1px solid;">Are all equipment and gadgets required mobilized and are they in working condition?</td>
                                <td class="text-center" style="border: 1px solid;"></td>
                                <td class="text-center" style="border: 1px solid;">
                                    <input class="form-check-input" type="checkbox" name="flexRadioDefault" id="flexRadioDefault1">
                                </td>
                                <td class="text-center" style="border: 1px solid;">
                                    <input class="form-check-input" type="checkbox" name="flexRadioDefault" id="flexRadioDefault1">
                                </td>
                            </tr>
                            {{-- Sub Header 2 Data --}}
                            <tr>
                                <td class="text-center" style="border: 1px solid;">K</td>
                                <td style="border: 1px solid;">Are all search kits and aids mobilized?</td>
                                <td class="text-center" style="border: 1px solid;"></td>
                                <td class="text-center" style="border: 1px solid;">
                                    <input class="form-check-input" type="checkbox" name="flexRadioDefault" id="flexRadioDefault1">
                                </td>
                                <td class="text-center" style="border: 1px solid;">
                                    <input class="form-check-input" type="checkbox" name="flexRadioDefault" id="flexRadioDefault1">
                                </td>
                            </tr>
                            {{-- Sub Header 2 Data --}}
                            <tr>
                                <td class="text-center" style="border: 1px solid;">L</td>
                                <td style="border: 1px solid;">Has all possible threats been assessed and remedies planned and initiated?</td>
                                <td class="text-center" style="border: 1px solid;"></td>
                                <td class="text-center" style="border: 1px solid;">
                                    <input class="form-check-input" type="checkbox" name="flexRadioDefault" id="flexRadioDefault1">
                                </td>
                                <td class="text-center" style="border: 1px solid;">
                                    <input class="form-check-input" type="checkbox" name="flexRadioDefault" id="flexRadioDefault1">
                                </td>
                            </tr>
                            {{-- Sub Header 2 Data --}}
                            <tr>
                                <td class="text-center" style="border: 1px solid;">M</td>
                                <td style="border: 1px solid;">Has transport been arranged?</td>
                                <td class="text-center" style="border: 1px solid;"></td>
                                <td class="text-center" style="border: 1px solid;">
                                    <input class="form-check-input" type="checkbox" name="flexRadioDefault" id="flexRadioDefault1">
                                </td>
                                <td class="text-center" style="border: 1px solid;">
                                    <input class="form-check-input" type="checkbox" name="flexRadioDefault" id="flexRadioDefault1">
                                </td>
                            </tr>
                            {{-- Sub Header 2 Data --}}
                            <tr>
                                <td class="text-center" style="border: 1px solid;">N</td>
                                <td style="border: 1px solid;">Is the suspect in the premises or within reach?</td>
                                <td class="text-center" style="border: 1px solid;"></td>
                                <td class="text-center" style="border: 1px solid;">
                                    <input class="form-check-input" type="checkbox" name="flexRadioDefault" id="flexRadioDefault1">
                                </td>
                                <td class="text-center" style="border: 1px solid;">
                                    <input class="form-check-input" type="checkbox" name="flexRadioDefault" id="flexRadioDefault1">
                                </td>
                            </tr>
                            {{-- Sub Header 2 Data --}}
                            <tr>
                                <td class="text-center" style="border: 1px solid;">O</td>
                                <td style="border: 1px solid;">Has the command post or the meeting point been identified and decided?</td>
                                <td class="text-center" style="border: 1px solid;"></td>
                                <td class="text-center" style="border: 1px solid;">
                                    <input class="form-check-input" type="checkbox" name="flexRadioDefault" id="flexRadioDefault1">
                                </td>
                                <td class="text-center" style="border: 1px solid;">
                                    <input class="form-check-input" type="checkbox" name="flexRadioDefault" id="flexRadioDefault1">
                                </td>
                            </tr>
                             {{-- Sub Header 2 Data --}}
                             <tr>
                                <td class="text-center" style="border: 1px solid;">P</td>
                                <td style="border: 1px solid;">Is a reinforcement team required and at hand in case of need?</td>
                                <td class="text-center" style="border: 1px solid;"></td>
                                <td class="text-center" style="border: 1px solid;">
                                    <input class="form-check-input" type="checkbox" name="flexRadioDefault" id="flexRadioDefault1">
                                </td>
                                <td class="text-center" style="border: 1px solid;">
                                    <input class="form-check-input" type="checkbox" name="flexRadioDefault" id="flexRadioDefault1">
                                </td>
                            </tr>
                            {{-- Sub Header 2 Data --}}
                            <tr>
                                <td class="text-center" style="border: 1px solid;">Q</td>
                                <td>Has the following people identified and appointed:
                                    <ul>
                                        <li>Search Officers</li>
                                        <li>Photographer</li>
                                        <li>Evidence recorder</li>
                                        <li>Sketch Preparer</li>
                                        <li>Guards for vital entry/exit points as per the sketch</li>
                                        <li>Crowd Controller</li>
                                    </ul>
                                </td>
                                <td class="text-center" style="border: 1px solid;"></td>
                                <td class="text-center" style="border: 1px solid;">
                                    <input class="form-check-input" type="checkbox" name="flexRadioDefault" id="flexRadioDefault1">
                                </td>
                                <td class="text-center" style="border: 1px solid;">
                                    <input class="form-check-input" type="checkbox" name="flexRadioDefault" id="flexRadioDefault1">
                                </td>
                            </tr>
                            {{-- Sub Header 2 Data --}}
                            <tr>
                                <td class="text-center" style="border: 1px solid;">R</td>
                                <td style="border: 1px solid;">Has appropriate arrangement been made with Secretariat for meals</td>
                                <td class="text-center" style="border: 1px solid;"></td>
                                <td class="text-center" style="border: 1px solid;">
                                    <input class="form-check-input" type="checkbox" name="flexRadioDefault" id="flexRadioDefault1">
                                </td>
                                <td class="text-center" style="border: 1px solid;">
                                    <input class="form-check-input" type="checkbox" name="flexRadioDefault" id="flexRadioDefault1">
                                </td>
                            </tr>
                    
                            {{-- Sub Header 3 --}}
                            <tr class="bg-secondary">
                                <th class="text-center" style="border: 1px solid;">3</th>
                                <th id="par" colspan="4" scope="colgroup" style="border: 1px solid;"><b>After Operation</b></th>
                            </tr>
                            {{-- Sub Header 3 Data --}}
                            <tr>
                                <td class="text-center" style="border: 1px solid;">A</td>
                                <td style="border: 1px solid;">Has any place been missed out?</td>
                                <td class="text-center" style="border: 1px solid;"></td>
                                <td class="text-center" style="border: 1px solid;">
                                    <input class="form-check-input" type="checkbox" name="flexRadioDefault" id="flexRadioDefault1">
                                </td>
                                <td class="text-center" style="border: 1px solid;">
                                    <input class="form-check-input" type="checkbox" name="flexRadioDefault" id="flexRadioDefault1">
                                </td>
                            </tr>
                            {{-- Sub Header 3 Data --}}
                            <tr>
                                <td class="text-center" style="border: 1px solid;">B</td>
                                <td style="border: 1px solid;">Are all the items secured and accounted for?</td>
                                <td class="text-center" style="border: 1px solid;"></td>
                                <td class="text-center" style="border: 1px solid;">
                                    <input class="form-check-input" type="checkbox" name="flexRadioDefault" id="flexRadioDefault1">
                                </td>
                                <td class="text-center" style="border: 1px solid;">
                                    <input class="form-check-input" type="checkbox" name="flexRadioDefault" id="flexRadioDefault1">
                                </td>
                            </tr>
                            {{-- Sub Header 3 Data --}}
                            <tr>
                                <td class="text-center" style="border: 1px solid;">C</td>
                                <td style="border: 1px solid;">Are all the equipment deployed in the operation checked and retrieved?</td>
                                <td class="text-center" style="border: 1px solid;"></td>
                                <td class="text-center" style="border: 1px solid;">
                                    <input class="form-check-input" type="checkbox" name="flexRadioDefault" id="flexRadioDefault1">
                                </td>
                                <td class="text-center" style="border: 1px solid;">
                                    <input class="form-check-input" type="checkbox" name="flexRadioDefault" id="flexRadioDefault1">
                                </td>
                            </tr>
                        </table>

                        <br>

                        

                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <button type="submit" class="btn btn-info" onclick="return printPage();" value="GeneratePdf">Print</button>
                </div>
            </div>
        </div>
    </div>
</section>


<script>
    function printPage() {
        var dataToPrint = document.getElementById("printSearchCheckList");
        newWin = window.open("");
        newWin.document.write(dataToPrint.outerHTML);
        newWin.print();
        newWin.close();
  }

    function showform() {
        $('#table1s').show(1000);
    }

    function hideDetails2() {
        $('#table1s').hide(1000);
    }

    $(document).ready(function () {
        $("#open").click(function () {
            $(".coi_show").animate({
                height: "toggle"
            }, 500);
            $(".coi_hide").hide();
        });
        $("#close").click(function () {
            $(".coi_show").hide();

        });
    });
</script>

@endsection