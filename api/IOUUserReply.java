package se.uu.it.fridaypub;

import org.json.JSONException;
import org.json.JSONObject;

public class IOUUserReply
{
    public int user_id;
    public String first_name;
    public String last_name;
    public float assets;

    public IOUUserReply(JSONObject jobj) throws JSONException
    {
        user_id = jobj.getInt("user_id");
        first_name = jobj.getString("first_name");
        last_name = jobj.getString("last_name");
        assets = Float.parseFloat(jobj.getString("assets"));
    }
}


class IOUUserReplyFactory implements ReplyFactory<IOUUserReply>
{
    public IOUUserReply create(JSONObject jobj) throws JSONException
    {
        return new IOUUserReply(jobj);
    }
}
