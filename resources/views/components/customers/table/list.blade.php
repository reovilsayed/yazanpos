<table class="list_table all">
    <thead>
        <tr>

            <th scope="col">Name</th>
            <th scope="col">Email</th>
            <th scope="col">Phone</th>
            <th scope="col">Address</th>
            <th scope="col">Gender</th>
            <th scope="col">Discount</th>
            <th scope="col">Due</th>
            <th scope="col">Action</th>


        </tr>
    </thead>
    <tbody>
        @foreach ($customers as $customer)
        
               <x-customers.table.row :customer="$customer"/>
         @endforeach
       
    </tbody>
</table>