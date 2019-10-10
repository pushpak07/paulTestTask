<template>
<div class="container-fluid">
    <div class="row">  
        <div class="col-lg-10 offset-lg-1 col-12">
            <table id="example" class="table table-responsive display nowrap" style="width:100%">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Bedroom</th>
                        <th>Bathroom</th>
                        <th>Property type</th>
                        <th>Status</th>
                        <th>For sale</th>
                        <th>For rent</th>
                        <th>Project name</th>
                        <th>Country</th>
                    </tr>
                </thead>
                <tbody>
                    
                </tbody>
                <tfoot>
                    <tr>
                        <th>title</th>
                        <th>description</th>
                        <th>bedroom</th>
                        <th>bathroom</th>
                        <th>property type</th>
                        <th>status</th>
                        <th>for sale</th>
                        <th>for rent</th>
                        <th>project name</th>
                        <th>country</th>
                    </tr>
                </tfoot>
            </table>
        </div> 
    </div>
</div>
</template>

<script>
    
    export default {
       
        data()
        {
            return{
                project_list : [],
            }
        },
        methods:{
           display_project() {
                $(document).ready(function() {
                    $("#example").dataTable().fnDestroy();
                    $('#example').DataTable({
                        responsive: {
                            details: {
                                type: 'column',
                                target: 'tr'
                            }
                        },
                        columnDefs: [{
                            className: 'control',
                            /*orderable: false,*/
                            orderable: true,
                            targets: 0
                        }],
                        order: [1, 'asc'],
                        "pageLength": 20,
                        "lengthChange": false,
                        "processing": true,
                        orderCellsTop: true,
                        fixedHeader: true,
                        "language": {
                            processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '
                        },
                        "serverSide": true,
                        "ajax": {
                            "url": "http://127.0.0.1:8000/projects-data",
                            "dataType": "json",
                            "type": "get",
                            "data": {
                                _token: "{{csrf_token()}}"
                            }
                        },
                        columns: [{
                                "data": "title",
                                "name": 'properties.title'
                            },
                            {
                                "data": "description",
                                "name": 'properties.description'
                            },
                            {
                                "data": "bedrooms",
                                "name": 'properties.bedrooms'
                            },
                            {
                                "data": "bathrooms",
                                "name": 'properties.bathrooms'
                            },
                            {
                                "data": "type",
                                "name": 'property_types.type'
                            },
                            {
                                "data": "status_type",
                                "name": 'status.status_type'
                            },
                            {
                                "data": "for_sale",
                                "name": 'properties.for_sale'
                            },
                            {
                                "data": "for_rent",
                                "name": 'properties.for_rent'
                            },
                            {
                                "data": "name",
                                "name": 'projects.name'
                            },
                            {
                                "data": "country",
                                "name": 'country.country'
                            },
                        ],
                        initComplete: function() {
                            var api = this.api();

                            // Apply the search
                            api.columns().every(function() {
                                var that = this;

                                $('input', this.footer()).on('keyup change', function() {
                                    if (that.search() !== this.value) {
                                        that

                                            .column($(this).parent().index())
                                            .search(this.value)
                                            .draw();
                                    }
                                });
                            });
                        }
                    });
                });

            },
        },
        mounted() {

            this.display_project()
            $(document).ready(function() {
                $('#example tfoot  th').each(function() {
                    var title = $(this).text();
                    $(this).html('<input type="text" class="my-form-control" placeholder="Search ' + title + '"/>');
                });
                $('tfoot').each(function() {
                    $(this).insertAfter($(this).siblings('thead'));
                });
            }); 

        },
        created() {
            this.display_project();
        },
    }
</script>
<style>
    thead input 
    {
        width: 100%;
    }
    .dataTables_filter, .dataTables_info 
    { 
        display: none; 
    }
    tfoot 
    {
        display: table-row-group;
    }
    .my-form-control
    {
        display: block;
        height: calc(1.6em + 0.75rem + 2px);
        padding: 0.375rem 0.75rem;
        font-size: 0.9rem;
        font-weight: 400;
        line-height: 1.6;
        color: #495057;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }
</style>
