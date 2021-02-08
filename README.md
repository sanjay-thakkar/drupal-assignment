# drupal8
This repository includes a custom drupal 8 module which consist of alteration of site configuration form.


This Assignment module will create a new field 'Site API Key' under site configuration form under admin panel of Drupal8 and will create one menu item under main menu with name 'JSON'.

### Site API Key Field
You can insert only alphanumeric characters with # and - allowed.

### JSON 
Once you will click on JSON menu item it will check certain validation criteria. Once every criteria will pass successfully and if site api key and given node id is of 'page' content type then it will load the JSON format of the node.

##### JSON format node representation URL
/page_json/{nid}

###### Reference
1) https://www.drupal.org
