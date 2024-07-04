<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Print</title>
        <style>
        .main-content {
            text-align: center;
            width: 100%;
        }

        table.table {
            width: 50%;
            margin: 0 auto;
            text-align: center;
        }
        </style>
    </head>
    <body>
        <div class="main-content">
            <div class="company-info">
                <div class="company-name"><p>{{$ticket->user->parkinglot->parking_name}}</p></div>
                <div class="parking-slip"><h2>Parking Slip</h2></div>
            </div>
            <div class="parking-info">
                <table class="table">
                    <tr>
                        <td>Date: {{$ticket->date}}</td>
                        <td>Time: {{$ticket->check_in}}</td>
                    </tr>
                    <tr>
                        <td>Vehicle type: {{$ticket->vehicle->type}} </td>
                        <td>Slot number: {{$ticket->slot->number}} </td>
                    </tr>
                    <tr>
                        <td>Parking no: {{$ticket->id}} </td>
                    </tr>
                </table>

                <p> For your own convenience, please do not loose the slip. </p>
            </div>
            <div class="parking-message">
                <p> THANK YOU AND DRIVE SAVELY!! </p>
            </div>
        </div>					
    </body>
</html>