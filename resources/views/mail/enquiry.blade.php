<table style="font-family: 'Arial', 'helvetica', sans-serif; width:800px">
    <tr>
        <td>

            <table>
                <tr>
                    <td style="width:400px; text-align: left; vertical-align: top;">
                        <h2>Website Enquiry - Office Copy</h2>
                    </td>
                    <td style="width:400px; text-align: right; vertical-align: top;">
                        {{ Date('g:ia - jS M Y') }}
                    </td>
                </tr>
            </table>

        </td>
    </tr>

    <tr>
        <td style="padding-bottom: 10px;">
            There has been a website enquiry with the following details
        </td>
    </tr>

    <tr>
        <td style="padding-bottom: 10px;">

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
            Please get back to the contact as soon as possible
        </td>
    </tr>
</table>
