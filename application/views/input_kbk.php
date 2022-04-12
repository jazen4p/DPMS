<html>
    <body>
        <form action="<?php echo base_url()?>Dashboard/add_input_kbk" method="POST">
            <table>
                <tr>
                    <td>ID PSJB</td>
                    <td><input type="text" name="idpsjb" value="<?php echo $id_kbk?>"></td>
                </tr>
                <tr>
                    <td>NO PSJB</td>
                    <td><input type="text" name="nopsjb" value="<?php echo $no_kbk?>"></td>
                </tr>
                <tr>
                    <td>KODE PERUMAHAN</td>
                    <td><input type="text" name="kodeperumahan" value="MSK"></td>
                </tr>
                <tr>
                    <td>NO UNIT</td>
                    <td><input type="text" name="nounit" autofocus></td>
                </tr>
            </table>

            <input type="submit">
        </form>
    </body>
</html>