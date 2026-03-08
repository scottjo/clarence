<table style="font-family: 'Arial', 'helvetica', sans-serif; width:800px">
    <tr>
        <td style="width:400px; text-align: left; vertical-align: top;">
            <h2>Website Enquiry Confirmation</h2>
        </td>
        <td style="width:400px; text-align: right" >
            <strong>Clarence Bowling Club</strong><br>
            Clarence Park<br>
            Weston-super-Mare<br>
            North Somerset<br>
            BS23 4BN<br>
            <br>
            {{ Date('jS M Y') }}
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <h1>THANK YOU</h1>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <h2>We have received your enquiry</h2>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <p>We have received your enquiry and will endeavor to get back to you as soon as possible.<br>
                For your records, here is a copy of the information you submitted to us:</p>
        </td>
    </tr>
    <tr>
        <td colspan="2">

            <table style="width:100%;border-collapse: collapse; margin: 10px 0;">
                <tr style="font-weight: bold; background-color: #e6e6e6; padding: 5px 0;">
                    <td style="width:20%;">Name:</td>
                    <td>{{ $name }}</td>
                </tr>
                <tr style="font-weight: bold; background-color: #fff; padding: 5px 0;">
                    <td style="width:20%;">Phone:</td>
                    <td>{{ $phoneNumber }}</td>
                </tr>
                <tr style="font-weight: bold; background-color: #e6e6e6; padding: 5px 0;">
                    <td style="width:20%;">Email:</td>
                    <td>{{ $email }}</td>
                </tr>
                <tr style="font-weight: bold; background-color: #fff; padding: 5px 0;">
                    <td style="width:20%;">Subject:</td>
                    <td>{{ $messageSubject }}</td>
                </tr>
                <tr style="font-weight: bold; background-color: #e6e6e6; padding: 5px 0;">
                    <td style="width:20%;">Message:</td>
                    <td>{{ $messageContent }}</td>
                </tr>
            </table>

        </td>
    </tr>
    <tr>
        <td>
            In the meantime, should you have any questions, please do not hesitate to get in touch.<br>
            <br>
            <p>Best regards</p><br><br>
            <p><strong>Clarence Bowling Club</strong></p>
            <p><a href="https://clarencebowls.org" target="_blank">www.clarencebowls.org</a></p>
        </td>
    </tr>
</table>
