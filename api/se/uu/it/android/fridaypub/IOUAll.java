package se.uu.it.android.fridaypub;

import org.json.JSONException;
import org.json.JSONObject;

public class IOUAll extends FPDB
{
    public IOUAll(String url, String userName, String password) throws FPDBException {
		super(url + "?action=iou_get_all", userName, password);
	}
    
    class Reply extends FPDB.Reply
    {
        public String username;
        public String first_name;
        public String last_name;
        public float  assets;

        public Reply(JSONObject jobj) throws JSONException
        {
	        String assets_str;	// XXX Fulkod f�r test
	        username = jobj.getString("username");
	        first_name = jobj.getString("first_name");
	        last_name = jobj.getString("last_name");
	        assets_str = jobj.getString("assets");	// XXX Fulkod f�r test
	        assets = Float.parseFloat(assets_str);
        }
        
        public String toString() {
        	return first_name +" " + last_name + " (anv.namn: "+ username +") har " + assets + " kr p� banken.";
        }
    }

    @Override
    protected Reply createReply(JSONObject jarr) throws JSONException {
    	return new Reply(jarr);
    }
}
