          <div class="container-fluid text-container" style="width:90%;">
                <div class="table-responsive mt-2">
                            <table class="table table-bordered table-striped text-center center">
                                <thead>
                                    <tr>
                                        <th colspan="1">Image</th>
                                        <th colspan="2">Title</th>
                                        <th colspan="1">Departure</th>
                                        <th colspan="1">Arrival</th>
                                        <th colspan="1">Cabins</th>
                                        <th colspan="1">Adults</th>
                                        <th colspan="1">Children</th>
                                        <th colspan="2">Your message</th>
                                        <th colspan="1">Amount Payed</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                            
                                            while($row = $result->fetch_assoc()):
                                        ?>    
                                        <tr>
                                        <td><img src="<?= $row['trip_image'] ?>" width="60"> </td>
                                        <td colspan="2"><?= $row['title']?></td>
                                        <td colspan="1">Departure date:&nbsp;&nbsp;<?= $row['start_event'] ?> from&nbsp;&nbsp;<?= $row['departure_location']?></td>
                                        <td colspan="1">Arrival date:&nbsp;&nbsp;<?= $row['end_event'] ?> at&nbsp;&nbsp;<?= $row['arrival_location'] ?></td>
                                        <td colspan="1"><?= $row['CabinNo']?></td>
                                        <td colspan="1"><?= $row['AdultNo']?></td>
                                        <td colspan="1"><?= $row['ChildNo']?></td>
                                        <td colspan="2"><?= $row['trip_message']?></td>
                                        <td colspan="1">€ &nbsp;<?= number_format($row['total_price'],2)?></td>

                                    </tr>
                                        <?php endwhile; ?>

                                    <tr>
                                        <td colspan="10"><label>Total amount paid</label></td>
                                        <td><b>€ &nbsp;<?= number_format($sales_total,2)?></b></td>
                                    </tr>
                                </tbody>
                            </table>
            </div>
        </div>
