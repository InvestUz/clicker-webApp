from flask import Flask, render_template, jsonify
from flask_caching import Cache

app = Flask(__name__)

# Setup cache config (to optimize performance)
app.config['CACHE_TYPE'] = 'SimpleCache'
app.config['CACHE_DEFAULT_TIMEOUT'] = 300
cache = Cache(app)

# Initial state stored in cache
cache.set('user_earnings', 0)

@app.route('/')
def index():
    return render_template('index.html')

@app.route('/click', methods=['POST'])
def click():
    user_earnings = cache.get('user_earnings') or 0
    user_earnings += 1  # Increment earnings for each click
    cache.set('user_earnings', user_earnings)  # Update the cache
    return jsonify({'earnings': user_earnings})

if __name__ == '__main__':
    app.run(debug=True)
